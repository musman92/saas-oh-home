<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Laravel\Cashier\Cashier;
use App\Models\User;

class SubscriptionController extends Controller
{
  public function index()
  {
    $sub_admin = auth()->user()->created_by;
    $plans = Plan::select('plans.*', 'subscriptions.stripe_status')->where('level', 'sub_user')
      ->leftJoin('subscriptions', function($join) {
          $join->on('plans.stripe_plan_id', '=', 'subscriptions.stripe_price')
           ->where('subscriptions.stripe_status', 'active')
           ->where('subscriptions.user_id', auth()->user()->id);
      })
      ->where([
        'plans.user_id' => $sub_admin,
        'plans.level' => 'sub_user'
      ])
      ->groupBy('plans.id')
      ->get();
    return view('subscription.index', compact('plans'));
  }

  public function show($plan_id)
  {
    $plan = Plan::find($plan_id);

    $intent = auth()->user()->createSetupIntent();
    return view('subscription.show', compact('plan', 'intent'));
  }

  public function subscription(Request $request)
  {
    Cashier::useCustomerModel(User::class);

    $plan = Plan::find($request->plan);
    $user = $request->user();
  
    $subscription = $user->newSubscription('default', $plan->stripe_plan_id);
  
    $subscription->create($request->token, [
      'email' => $user->email
    ]);

    return redirect()->route('subs.index')->with('success', 'Subscription created successfully');
  }
}

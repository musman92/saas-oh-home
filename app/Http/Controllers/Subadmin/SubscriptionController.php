<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\Plan;
use App\Models\SubAdmin;

class SubscriptionController extends Controller
{
  public function index()
  {
    $plans = Plan::select('plans.*', 'subscriptions.stripe_status')->where('level', 'sub_admin')
      ->leftJoin('subscriptions', 'plans.stripe_plan_id', '=', 'subscriptions.stripe_price')
      ->groupBy('plans.id')
      ->get();
    return view('sub-admin.subscription.index', compact('plans'));
  }

  public function show($plan)
  {
    $plan = Plan::where('id', $plan)->first();

    $intent = auth()->guard('subadmin')->user()->createSetupIntent();
    return view('sub-admin.subscription.show', compact('plan', 'intent'));
  }

  public function subscription(Request $request)
  {
    Cashier::useCustomerModel(User::class);
    $plan = Plan::find($request->plan);
    $subscription = auth()->guard('subadmin')->user()
      ->newSubscription('default', $plan->stripe_plan_id)
      ->create($request->token);

    return redirect()->route('subs.index')->with('success', 'Subscription created successfully');
  }

}

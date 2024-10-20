<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class SubscriptionController extends Controller
{
  public function index()
  {
    $plans = Plan::select('plans.*', 'subscriptions.stripe_status')->where('level', 'sub_admin')
      ->leftJoin('subscriptions', 'plans.stripe_plan_id', '=', 'subscriptions.stripe_price')
      // ->where('subscriptions.stripe_status', '<>', 'incomplete')
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
    // dd($request->all());
    $plan = Plan::find($request->plan);
    $subscription = auth()->guard('subadmin')->user()
      ->newSubscription($request->plan, $plan->stripe_plan_id)
      ->create($request->token);
    dd($subscription);
  }

}

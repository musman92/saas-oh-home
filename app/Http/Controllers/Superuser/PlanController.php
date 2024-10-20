<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Plan as StripePlan;
use Stripe\Product;
use App\Models\Plan;

class PlanController extends Controller
{
  public function __construct()
  {
    Stripe::setApiKey(env('STRIPE_SECRET'));
  }

  public function index()
  {
    $plans = Plan::all();
    return view('super-user.plans.index', compact('plans'));
  }

  public function create() {
    return view('super-user.plans.create');
  }

  public function store(Request $request)
  {
    // add validation
    $request->validate([
      'name' => 'required|string|max:255',
      'amount' => 'required|numeric|min:1',
      'interval' => 'required|string|in:month,year',
    ]);

    // use db transaction
    \DB::beginTransaction();

    try {
      $product = Product::create([
        'name' => $request->name,
        'type' => 'service',
      ]);

      $stripePlan = StripePlan::create([
        'amount' => $request->amount * 100,
        'currency' => 'usd',
        'interval' => $request->interval,
        'product' => $product->id,
      ]);

      $plan = Plan::create([
        'user_id' => auth()->guard('superuser')->id(),
        'level' => 'sub_admin',
        'name' => $request->name,
        'amount' => $request->amount,
        'interval' => $request->interval,
        'interval_count' => 1,
        'stripe_plan_id' => $stripePlan->id,
        'stripe_plan' => json_encode($stripePlan),
        'stripe_product_id' => $product->id,
        'stripe_product' => json_encode($product),
      ]);

      \DB::commit();
      //redirect with success message
      return redirect()->route('superuser.plans.index')->with('success', 'Plan created successfully');
    } catch (\Exception $e) {
      \DB::rollBack();
      dd($e->getMessage());
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    $plan = Plan::create([
      'name' => $request->name,
      'amount' => $request->amount,
      'interval' => $request->interval,
    ]);

    return redirect()->route('superuser.plans.index');
  }


  public function charge(Request $request)
  {
    $charge = Charge::create([
      'amount' => $request->amount * 100,
      'currency' => 'usd',
      'source' => $request->stripeToken,
      'description' => 'Payment for ' . $request->description,
    ]);

    return response()->json($charge);
  }
}

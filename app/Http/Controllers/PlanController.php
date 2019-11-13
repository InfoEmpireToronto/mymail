<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\Charge;
use Stripe\Subscription;



class PlanController extends Controller
{
    //

	public function index()
	{
	        	Stripe::setApiKey(env('STRIPE_SECRET'));
			$planDetails = false;
	        $plans = Plan::all();
	        $invoices = false;
	        if(auth()->user()->subscription('main'))
	        {
	        	$planDetails = Subscription::retrieve(auth()->user()->subscription('main')->stripe_id);
	        	// $planDetails = auth()->user()->subscription('main');
	        }

	        if(auth()->user()->stripe_id)
	        {
	        	$invoices = Invoice::all(['limit' => 10, 'customer' => auth()->user()->stripe_id]);
	        }

	        return view('plans.index', [
	        	'plans' => $plans,
	        	'planDetails' => $planDetails,
	        	'invoices' => $invoices
	        ]);

	        // return view('plans.index', compact('plans'));
	}

	public function show(Plan $plan, Request $request)
	{
		// dd($request->user()->invoice());
	        	// Stripe::setApiKey(env('STRIPE_SECRET'));

		// dd();

        if($request->user()->subscribedToPlan($plan->stripe_plan, 'main')) 
        {
            return redirect()->route('home')->with('success', 'You have already subscribed the plan');
        }
        return view('plans.show', compact('plan'));
 	}

}

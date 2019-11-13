<?php

// SubscriptionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Subscription;

use App\Services\Twilio;

class SubscriptionController extends Controller
{
    
	public function create(Request $request, Plan $plan)
	{
	        if($request->user()->subscribedToPlan($plan->stripe_plan, 'main')) {
	            return redirect()->route('home')->with('success', 'You have already subscribed the plan');
	        }
	        $plan = Plan::findOrFail($request->get('plan'));



	        $message = 'Thanks for subscribing!';

	        $twilio = new Twilio();

	        $twilio->send($request->user()->phone, $message);


	        
	        $request->user()
	            ->newSubscription('main', $plan->stripe_plan)
	            ->create($request->stripeToken);
	        
	        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
	}

	public function cancel(Request $request, Plan $plan)
	{
		Stripe::setApiKey(env('STRIPE_SECRET'));

		if($request->user()->subscribedToPlan($plan->stripe_plan, 'main')) 
		{

			$sub = Subscription::retrieve($request->user()->subscription('main')->stripe_id);
			$sub->cancel();

			$request->user()->subscription('main')->delete();
		}
		

		return redirect()->route('home')->with('success', 'Your plan subscription canceled');

	}
}
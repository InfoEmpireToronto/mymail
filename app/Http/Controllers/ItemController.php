<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;


class ItemController extends Controller
{
    //

	public function index()
	{
	        $items = Item::all();
	        return view('items.index', compact('items'));
	}

	public function show(Item $item, Request $request)
	{
        
        return view('items.show', compact('item'));
 	}

	public function buy(Request $request)
	{
        $item = Item::find($request->item);

		Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Customer::create(array(
            'email' => auth()->user()->email,
            'source'  => $request->stripeToken
        ));

        $charge = Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $item->cost*100,
            'currency' => 'cad'
        ));

	    return redirect()->route('home')->with('success', 'Thank you for paying!');

 	}

}

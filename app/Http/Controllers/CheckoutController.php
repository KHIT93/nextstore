<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function signin()
    {
        return view('checkout.login');
    }

    public function register(Request $request)
    {
        if($request->input('checkoutType') == 'register')
        {
            return redirect('/register');
        }

        return redirect(route('checkout.address.billing'));
    }

    public function billingAddress()
    {
        if(request()->expectsJson())
        {
            return auth()->user()->addresses()->where('billing', 1)->get();
        }
        return view('checkout.address.billing');
    }

    public function shippingAddress()
    {
        if(request()->expectsJson())
        {
            return auth()->user()->addresses()->where('shipping', 1)->get();
        }
        return view('checkout.address.shipping');
    }

    public function createAddress()
    {
        return view('checkout.address.billingaddressform', ['type' => request()->get('type')]);
    }

    public function storeAddress(Request $request)
    {
        auth()->user()->addresses()->create($request->all());
        return redirect('checkout.address.'.$request->input('type'));
    }

}

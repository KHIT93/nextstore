<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = $this->getCurrentCart();

        $cart->addItem($request['product_id'], $request['qty']);
        //$cart->fresh()->calculateTotal();

        return ($request->expectsJson() ? $cart : redirect(route('cart.show')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $cart = $this->getCurrentCart();
        if(request()->expectsJson())
        {
            return $cart;
        }
        return view('cart.show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request)
    {
        $cart = $this->getCurrentCart();
        $cart->updateItem($request['product_id'], $request['qty']);
        return ($request->expectsJson() ? $cart->fresh() : redirect(route('cart.show')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteItem(Request $request)
    {
        $cart = $this->getCurrentCart();
        $cart->deleteItem($request['product_id']);
        return ($request->expectsJson() ? $cart->fresh() : redirect(route('cart.show')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    protected function getCurrentCart()
    {
        $cart = null;
        if(!session()->has('cart_id'))
        {
            $cart = Cart::create(['user_id' => auth()->id()]);
            session(['cart_id' => $cart->id]);
        }
        return (is_null($cart) ? Cart::where('id', '=', session('cart_id'))->first() :  $cart);
    }
}

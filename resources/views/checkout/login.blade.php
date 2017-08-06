@extends('layouts.app')

@section('title')
    Checkout
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Checkout method</div>
                    <div class="card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Checkout as guest or create an account</h4>
                                    <hr>
                                    <h5>Benefits of an account with us</h5>
                                    <p>When you create an account with us, you will get these benefits:</p>
                                    <ul>
                                        <li>Fast and easy checkout</li>
                                        <li>Easy access to order history and order status</li>
                                        <li>An easy way to reorder a previous order</li>
                                    </ul>
                                    <hr>
                                    <p><strong>Tell us how you want to proceed:</strong></p>
                                    <form method="POST" action="/checkout/register" role="form">
                                        {!! csrf_field() !!}
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="checkoutType" value="guest">
                                                I want to checkout as a guest
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="checkoutType" value="register">
                                                I want to register an account
                                            </label>
                                        </div>
                                        <div class="d-flex flex-row-reverse">
                                            <button type="submit" class="btn btn-primary">Continue</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <h4>Log in to your existing account</h4>
                                    <hr>
                                    @include('auth.components.login_form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

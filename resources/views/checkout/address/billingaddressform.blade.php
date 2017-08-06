@extends('layouts.app')

@section('title')
Manage billing address
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-block">
                        <h4>Create billing address</h4>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('checkout.address.billing')}}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="id"/>
                                    <div class="container">
                                        <div class="form-group row">
                                            <label for="firstname" class="col-sm-3 col-form-label">First name*</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="firstname" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastname" class="col-sm-3 col-form-label">Last name*</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="lastname" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="company" class="col-sm-3 col-form-label">Company</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="company" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="street1" class="col-sm-3 col-form-label">Address*</label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="text" name="street1" class="form-control" required/>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="street2" class="form-control"/>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="street3" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zipcode" class="col-sm-3 col-form-label">ZIP-code*</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="zipcode" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="city" class="col-sm-3 col-form-label">City*</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="city" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="country" class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="country" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="tel" name="phone" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                            <div class="col-sm-9">
                                                <input type="tel" name="mobile" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tin" class="col-sm-3 col-form-label">TIN</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="tin" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="deliveryAddress" value="1">
                                                        This is address is also the shipping/delivery address
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row-reverse">
                                            <button type="submit" class="btn btn-primary">Continue</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

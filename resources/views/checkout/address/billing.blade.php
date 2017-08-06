@extends('layouts.app')

@section('title')
Choose billing address
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Billing address</div>
                    <div class="card-block">
                        <h4>Choose your billing address</h4>
                        <hr>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card card-outline-primary cursor-pointer">
                                        <div class="card-block">
                                            <small>
                                                Firstname Lastname<br>
                                                Street1<br>
                                                Street2<br>
                                                Street3<br>
                                                1234 City<br>
                                                Country<br>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card card-outline-primary cursor-pointer">
                                        <div class="card-block">
                                            <small>
                                                Firstname Lastname<br>
                                                Street1<br>
                                                Street2<br>
                                                Street3<br>
                                                1234 City<br>
                                                Country<br>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <a href="/checkout/address/create?type=billing" class="btn btn-info cursor-default"><i class="fa fa-plus" aria-hidden="true"></i> Create billing address</a>
                            <a href="/checkout/address/create?type=shipping" class="btn btn-info cursor-default"><i class="fa fa-plus" aria-hidden="true"></i> Create shipping address</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

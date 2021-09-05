@extends('layouts.app')

@section('content')
    <div class="content-body">
        <div class="content-wrapper">
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{session('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-md-5 col-sm-12 mb-3">
                            <div class="card card-primary mb-3">
                                <div  class="card-body box-profile">
                                        <div class="avatar avatar-xxl {{($customer->active)?'avatar-online' : 'avatar-offline'}} m-auto">
                                                <img class="profile-user-img img-fluid img-circle"
                                                     src="{{asset('assets/img/avatar.svg')}}"
                                                     alt="User profile picture">
                                        </div>

                                    <h3 class="profile-username text-center mt-2">{{$customer->name}}</h3>

                                    <p class="text-muted text-center">{{$customer->username}}</p>

                                    <p class="text-muted text-center">

                                    @if($customer->free_account)
                                    <span class="badge badge-info p-2 mr-2" style="font-size: 0.9rem">Free Account</span>
                                    @endif
                                    @if($customer->discount != 0)
                                    <span class="badge badge-warning p-2" style="font-size: 0.9rem">{{$customer->discount}}% Discount</span>
                                    @endif
                                    </p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Due Balance</b> <a class="float-right"> {{$balance}} LBP</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Plan</b> <a class="float-right">{{$customer->plan()->first()->name}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Employee</b> <a class="float-right">{{$customer->employee()->first()->name}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            @if($customer->active)
                                                <b>Status</b> <a class="float-right"><span class="badge badge-success p-1" style="font-size: 0.7rem">Active</span></a>
                                            @else
                                                <b>Status</b> <a class="float-right"><span class="badge badge-light p-1" style="font-size: 0.7rem">Inactive</span></a>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            <b>Expires At</b> <a class="float-right">{{$customer->expires_at}}</a>
                                        </li>

                                        @if($customer->custom_price != 0)
                                        <li class="list-group-item">
                                            <b>Custom Price</b> <a class="float-right">{{($customer->custom_price == 0) ?  'Not Available' : $customer->custom_price}} LBP</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Customer Information</h3>
                                </div>

                                <div class="card-body">
                                    <strong><i class="fas fa-phone mr-1 mb-3"></i> Phone</strong>

                                    <p class="text-muted">
                                        {{$customer->phone}}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1 mb-3"></i> Location</strong>

                                    <p class="text-muted">{{ $customer->area()->first()->name . ', ' . $customer->street()->first()->name .', ' . $customer->building()->first()->name}}</p>

                                    <hr>

                                    <strong><i class="fas fa-box mr-1 mb-3"></i> Box</strong>

                                    <p class="text-muted">{{ $customer->box()->first()->name }}</p>

                                    <hr>

                                    <strong><i class="fas fa-cogs mr-1 mb-3"></i>Services</strong>

                                    <p class="text-muted">



                                        @foreach($customer->services()->get() as $service)
                                        <span class="badge badge-info p-2" style="font-size: 0.7rem">{{$service->name}}</span>
                                        @endforeach

                                        @if($customer->iptv()->first() != null)
                                                <span class="badge badge-info p-2" style="font-size: 0.7rem">{{$customer->iptv()->first()->name}}</span>
                                        @endif
                                    </p>

                                    <hr>

                                    <strong><i class="far fa-file-alt mr-1 mb-3"></i> Notes</strong>
                                    <p class="text-muted">{{$customer->notes}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 col-sm-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#invoices" data-toggle="tab">Invoices</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#due-payment" data-toggle="tab">Due Payments</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#recharge" data-toggle="tab">Recharge</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Update Customer Details</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="invoices">

                                            <table id="invoices-table" class="table">
                                                <thead>
                                                <tr>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">#</th>

                                                    <th class="desktop tablet-l">Employee</th>
                                                    <th class="desktop tablet-l">Date</th>
                                                    <th class="desktop tablet-l">Total</th>
                                                    <th class="desktop tablet-l">Due</th>
                                                    <th class="desktop tablet-l">Status</th>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                               @foreach($invoices as $invoice)
                                                        <tr>
                                                            <td>{{$invoice->id}}</td>

                                                            <td>{{$invoice->employee()->first()->name}}</td>
                                                            <td>{{$invoice->issued_at}}</td>
                                                            <td>{{ $invoice->total}}</td>
                                                            <td>{{ $invoice->due}}</td>
                                                            @if($invoice->due != 0)
                                                                <td class="text-center"><span class="badge badge-danger p-2" style="font-size: 0.7rem">Due</span></td>
                                                            @endif
                                                            @if($invoice->due == 0)
                                                                <td class="text-center"><span class="badge badge-success p-2" style="font-size: 0.7rem">Paid</span></td>
                                                            @endif
                                                            <td class="text-center">
                                                                <a href="" class="btn btn-xs btn-primary pr-3"><i class="fas fa-print tx-white"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="tab-pane" id="due-payment">

                                            <table id="due-table" class="table">
                                                <thead>
                                                <tr>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">#</th>
                                                    <th class="desktop tablet-l">Amount</th>
                                                    <th class="desktop tablet-l">Employee</th>
                                                    <th class="desktop tablet-l">Due Date</th>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($dues as $invoice)
                                                        <tr>
                                                            <td>{{$invoice->id}}</td>
                                                            <td>{{ $invoice->due}}</td>
                                                            <td>{{$invoice->employee()->first()->name}}</td>
                                                            <td>{{$invoice->issued_at}}</td>
                                                            <td class="text-center">
                                                                <a href="" class="btn btn-xs btn-primary pr-3"><i class="fas fa-dollar-sign tx-white"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane" id="recharge">
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <h5 class="tx-danger"> Please check the following fields:</h5>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li class="h6 tx-danger">{{ $error }}</li>
                                                        @endforeach
                                                    </ul>

                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <form id="recharge-customer" method="post" action="{{route('customers.recharge',$customer->id)}}"  data-parsley-validate>

                                                @csrf()

                                                <fieldset class="form-fieldset mb-2">
                                                    <legend>Recharge Information</legend>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Plan Price: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="plan_price" type="number" name="plan_price" class="form-control" placeholder="Enter plan cost" value="{{$customer->plan()->first()->price}}" readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Services Total: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="services_price" type="number" name="services_price" class="form-control" placeholder="Enter plan cost" value="{{$serviceCost}}" readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>IPTV Price: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="iptv_price" type="number" name="iptv_price" class="form-control" placeholder="Enter plan cost" value="{{$customer->iptv()->first()->price}}" readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Custom Price: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="custom_price" type="number" name="custom_price" class="form-control" placeholder="Enter plan cost" value="{{($customer->custom_price != 0 )? $customer->custom_price : 0}}" readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Discount:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                                    </div>
                                                                    <input id="discount" type="number" name="discount" class="form-control" placeholder="Enter discount rate" data-parsley-min="0" data-parsley-max="100" value="{{(old('discount'))? old('discount') : $customer->discount}}">
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Total Price: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="total_price" type="number" name="total_price" class="form-control" placeholder="Calculated total Price"  readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-fieldset">
                                                    <legend>Recharge Options</legend>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Date of Expiration: <span class="tx-gray-400"> (On Radius)</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                                    </div>
                                                                    <input id="expires_at" type="text" name="expires_at" class="form-control" placeholder="Expiry date from radius" readonly>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Next Expiration Date:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                                    </div>
                                                                    <input id="new_expire" type="text" name="new_expire" class="form-control"  value="{{date('Y/m/d',strtotime('+30 days',strtotime( $customer->expires_at)))}}" readonly>

                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" value="1" class="custom-control-input" name="paid" id="paid" {{ old('paid') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="paid">Set Paid</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" value="1" class="custom-control-input" id="recharge_radius" name="recharge_radius" {{ old('recharged_radius') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="recharge_radius">Recharge on Radius</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <fieldset class="form-fieldset">
                                                        <legend>Recharge Method</legend>
                                                        <div class="row mt-4 mb-4">
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="using_balance"  value="balance" name="recharge_method" class="custom-control-input" checked>
                                                                    <label class="custom-control-label" for="using_balance">Using Balance</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="using_card" value="card" name="recharge_method" class="custom-control-input">
                                                                    <label class="custom-control-label" for="using_card">Using Card</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Card Number</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                                        </div>
                                                                        <input id="card_number" type="text" name="card_number" class="form-control"  placeholder="Enter redeemed card number" value="" disabled>

                                                                    </div>
                                                                </div><!-- form-group -->
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="row mt-2 mb-2 ">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Notes:</label>
                                                                <textarea class="form-control" id="notes" rows="3" placeholder="Notes" name="notes">{{old('notes')}}</textarea>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="row mb-3 mt-3">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary">Recharge</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane" id="edit">
                                            <form id="create-user" action="#" method="post" data-parsley-validate>

                                                @csrf

                                                <fieldset class="form-fieldset mb-2">
                                                    <legend>Personal Information</legend>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Customer Name: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                                    </div>
                                                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" autocomplete="name" value="{{old('name')}}" required>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Phone Number: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                                        <span class="input-group-text"> (+961)</span>
                                                                    </div>
                                                                    <input id="inputPhoneNumber" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="tel-national" value="{{old('phone')}}" required>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <legend class="mb-3 mt-4">Residential Information</legend>
                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Area: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="area" required>
                                                                        <option value="" {{(old('area') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($areas as $area)
                                                                            <option value="{{$area->id}}" {{(old('area') == $area->id)  ? 'selected' : ''}}>{{$area->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Street: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-road"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="street" disabled required>
                                                                        <option value="" {{(old('street') == '')  ? 'selected' : ''}}>Choose area first</option>
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Building: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="building" disabled required>
                                                                        <option value="" {{(old('building') == '')  ? 'selected' : ''}}>Choose street first</option>
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Box: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="box" disabled required>
                                                                        <option value="" {{(old('box') == '')  ? 'selected' : ''}}>Choose building first</option>
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-fieldset mb-2">
                                                    <legend> User Credentials</legend>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Username: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                                                    </div>
                                                                    <input type="text" name="username" class="form-control" placeholder="Enter Username" autocomplete="username" value="{{old('username')}}" required>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Password: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                    </div>
                                                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                </fieldset>

                                                <fieldset class="form-fieldset mb-2">
                                                    <legend>Services</legend>

                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Plan: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="plan" required>
                                                                        <option value="" {{(old('plan') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($plans as $plan)
                                                                            <option value="{{$plan->id}}" {{(old('plan') == $plan->id)  ? 'selected' : ''}}>{{$plan->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="enableIPTV" name="enableIPTV" {{ old('enableIPTV') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="enableIPTV">Enable IPTV</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label id="iptvLabel">IPTV: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-tv"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="iptv" id="iptv"  {{ old('enableIPTV') ? '' : 'disabled' }}>
                                                                        <option value="" {{(old('iptv') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($iptv as $tv)
                                                                            <option value="{{$tv->id}}" {{(old('iptv') == $tv->id)  ? 'selected' : ''}}>{{$tv->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Services: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                                                    </div>
                                                                    <select id="services" class="custom-select" name="service[]" id="service" multiple="multiple" >
                                                                        @foreach($services as $service)
                                                                            <option value="{{$service->id}}" {{old('service')?(in_array($service->id, old('service')) ? 'selected' : '') : ''}}>{{$service->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                </fieldset>

                                                <fieldset class="form-fieldset mb-2">
                                                    <legend>Administrative Information</legend>

                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Employee: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="employee" required>
                                                                        <option value="" {{(old('employee') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($employees as $employee)
                                                                            <option value="{{$employee->id}}" {{(old('employee') == $employee->id)  ? 'selected' : ''}}>{{$employee->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" value="1" class="custom-control-input" name="active" id="active" {{ old('active') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="active">Active</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" value="1" class="custom-control-input" id="free_account" name="free_account" {{ old('free_account') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="free_account">Free Account</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Expires At: <span class="tx-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                                    </div>
                                                                    <input id="inputExpire" type="text" name="expires_at" class="form-control" placeholder="Enter Expiry Date" value="{{old('expires_at')}}" required>

                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Cost: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                                    </div>
                                                                    <input id="inputCost" type="number" name="custom_price" class="form-control" placeholder="Enter custom price" value="{{old('custom_price')}}" >
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                                    </div>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Discount:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                                    </div>
                                                                    <input id="inputDiscount" type="number" name="discount" class="form-control" placeholder="Enter discount rate" value="{{old('discount')}}" >
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2 ">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Notes:</label>
                                                                <textarea class="form-control" rows="5" placeholder="Notes" name="notes">{{old('notes')}}</textarea>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary">Create</button>
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
            </div>
        </div>
    </div>


@endsection


@section('script')
    <script src="{{asset('lib/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/cleave.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/addons/cleave-phone.lb.js')}}"></script>
    <script src="{{asset('lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/select2/js/select2.min.js')}}"></script>

    <script type="text/javascript">

        let plan_price = parseFloat($("#plan_price").val());
        let iptv_price = parseFloat($("#iptv_price").val());
        let services_price = parseFloat($("#services_price").val());
        let custom_price = parseFloat($("#custom_price").val());
        let discount = parseFloat($("#discount").val());

        let total_price = iptv_price + services_price;

        if(custom_price == 0){
            total_price += plan_price;
        }else {
            total_price += custom_price;
        }

        let final_price = 0;

        final_price = total_price - (total_price * discount / 100);

        $("#total_price").val(final_price);

        $("#discount").on('change',function(){

            let discount = parseFloat($("#discount").val());
            final_price = total_price - (total_price * discount / 100);
            $("#total_price").val(final_price);
        });

        $("#using_card").on('change',function () {

            $("#card_number").prop('disabled', false);

        })

        $("#using_balance").on('change',function () {

            $("#card_number").prop('disabled', true);

        })

        $("#card_number").on('change',function () {

                $("#notes").val('Customer recharged using card #' + $("#card_number").val() + '.');
        })


        $( function() {
            $('#recharge-customer').parsley({
                errorsContainer: function(el) {
                    return el.$element.closest('.form-group');
                },
                errorClass: 'is-invalid',
                successClass: 'is-valid',
            });
        } );

        var due_invoices = $('#due-table').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var invoices = $('#invoices-table').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
@endsection

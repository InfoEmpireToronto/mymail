@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Plans</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($plans as $plan)
                        <li class="list-group-item clearfix">
                            <div class="pull-left">
                                <h5>{{ $plan->name }}</h5>
                                <h5>${{ number_format($plan->cost, 2) }} monthly</h5>
                                <h5>{{ $plan->description }}</h5>
@if(!auth()->user()->subscribedToPlan($plan->stripe_plan, 'main'))
    <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-outline-dark pull-right">Choose</a>
@else
    <a href="{{ route('subscription.cancel', $plan->slug) }}" class="btn btn-outline-dark pull-right">Cancel Plan!</a>
@endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@if($planDetails)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Plan Details</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item clearfix">
                            <div class="pull-left">


                                <div>Status: {{ $planDetails->status }} </div>
                                <div>Period Start: {{ date("H:m:s  (Y-m-d)", $planDetails->current_period_start) }} </div>
                                <div>Period End: {{ date("H:m:s  (Y-m-d)", $planDetails->current_period_end) }} </div>
                                <div>Billing: {{ date("H:m:s  (Y-m-d)", $planDetails->billing_cycle_anchor) }} </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
@if($invoices)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoices</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item clearfix">
                            <div class="pull-left">

                                @foreach($invoices as $key => $inv)

                                    <div><a href="{{ $inv->hosted_invoice_url }}" target="_new">Invoice {{ $key }}</a></div>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
@endsection
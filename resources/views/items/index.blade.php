@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Items</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($items as $item)
                        <li class="list-group-item clearfix">
                            <div class="pull-left">
                                <h5>{{ $item->name }}</h5>
                                <h5>${{ number_format($item->cost, 2) }}</h5>
                                <h5>{{ $item->description }}</h5>

    <a href="{{ route('items.show', $item->slug) }}" class="btn btn-outline-dark pull-right">Buy Now</a>

                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
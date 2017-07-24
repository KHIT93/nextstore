@extends('layouts.app')
@section('title')
    @if($active_category)
        {{ $active_category->name }}
    @else
        {{ config('app.name', 'Laravel') }}
    @endif
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <nav class="nav flex-column">
            @foreach($categories as $category)
                <a class="nav-link {{ ($active_category->is($category)) ? 'active': '' }}" href="/categories/{{ $category->id }}">{{ $category->name }}</a>
            @endforeach
            </nav>
        </div>
        <div class="col-sm-8">
            @foreach($products as $productSet)
            <div class="row">
                @foreach($productSet as $product)
                <v-product-card :product='{!! $product !!}'></v-product-card>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title')
    {{ $product->name }}
@endsection
@section('content')
<v-product :product='{!! $product !!}'></v-product>
@endsection

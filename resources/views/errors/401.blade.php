@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. This page has gone missing.</div>
    <div class="intro-x text-lg mt-3">You may have mistyped the address or the page may have moved.</div>
@endsection

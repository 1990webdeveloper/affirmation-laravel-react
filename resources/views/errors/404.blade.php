@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <div class="intro-x text-xl text-[24px] font-medium mt-5 uppercase">oops! page not found </div>
    {{-- <div class="intro-x text-lg mt-3">You may have mistyped the address or the page may have moved.</div> --}}
@endsection

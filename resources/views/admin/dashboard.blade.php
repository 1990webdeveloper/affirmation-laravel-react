@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="content">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 2xl:col-span-12">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 flex items-center justify-center text-center  h-[calc(80vh-30px)]">
                        <div class="p-5 mt-5">
                            <div class="-intro-y">
                                <img alt="img" class=" mx-auto" src="{{ asset('dist/images/slide-2.png') }}">
                            </div>
                            <div class="text-box text-2xl font-semibold mt-10 lg:mt-5">
                                Welcome to MyAffirmations
                            </div>
                        </div>
                    </div>
                    <!-- END: General Report -->
                </div>
            </div>
        </div>
    </div>
@endsection

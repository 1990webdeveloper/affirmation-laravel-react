@extends('layouts.master')
@section('title', 'Setting')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
    <div class="content">
        <div class="grid grid-cols-12 gap-3 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">
                            Settings
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3">
            <div class="md:col-span-3 col-span-12">
                <div class="intro-y box mt-5">
                    <ul class="nav nav-boxed-tabs flex flex-col px-3 py-4" role="tablist">
                        <li id="bb-tab" class="nav-item flex-1 mb-2 shadow-sm" role="presentation">
                            <button class="nav-link text-left flex items-center gap-2 w-full py-2 active"
                                data-tw-toggle="pill" data-tw-target="#bb-target" type="button" role="tab"
                                aria-controls="bb-target" aria-selected="true">
                                <i data-lucide="activity"></i> Binaural Beats Settings
                            </button>
                        </li>
                        <li id="ba-tab" class="nav-item flex-1 mb-2 shadow-sm" role="presentation">
                            <button class="nav-link text-left flex items-center gap-2 w-full py-2" data-tw-toggle="pill"
                                data-tw-target="#ba-target" type="button" role="tab" aria-controls="ba-target"
                                aria-selected="false">
                                <i data-lucide="music"></i>Background Audio Settings
                            </button>
                        </li>
                        <li id="ar-tab" class="nav-item flex-1 mb-2 shadow-sm" role="presentation">
                            <button class="nav-link text-left flex items-center gap-2 w-full py-2 " data-tw-toggle="pill"
                                data-tw-target="#ar-target" type="button" role="tab" aria-controls="ar-target"
                                aria-selected="true">
                                <i data-lucide="mic"></i> Audio Record Settings
                            </button>
                        </li>
                        <li id="banner-tab" class="nav-item flex-1 mb-2 shadow-sm" role="presentation">
                            <button class="nav-link text-left flex items-center gap-2 w-full py-2 " data-tw-toggle="pill"
                                data-tw-target="#banner-target" type="button" role="tab" aria-controls="banner-target"
                                aria-selected="true">
                                <i data-lucide="image"></i> Banner Settings
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="intro-y md:col-span-9 col-span-12">
                <div class="intro-y box mt-5">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <div class="tab-content py-1">
                                <div id="bb-target" class="tab-pane leading-relaxed active" role="tabpanel"
                                    aria-labelledby="bb-tab">

                                    <div id="vertical-form" class="p-0">
                                        <form class="form-horizontal" method="POST" action="{{ route('setting.store') }}"
                                            id="bbForm">
                                            @csrf
                                            <input type="hidden" name="form_name" value="bbForm" />
                                            <div class="preview  lg:w-1/2">
                                                <div>
                                                    <label for="bb_space_limit" class="form-label">Space Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="bb_space_limit" type="number" name="bb_space_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Space Limit" id="bb_space_limit"
                                                        value="{{ $settings['bb_space_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add space limit in
                                                        MB</span>
                                                    @error('bb_space_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mt-3">
                                                    <label for="bb_time_limit" class="form-label">Time Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="bb_time_limit" type="number" name="bb_time_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Time Limit" id="bb_time_limit"
                                                        value="{{ $settings['bb_time_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add time limit in
                                                        Minute</span>
                                                    @error('bb_time_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-primary mt-5" id="bb-form">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <!---Binaural Beats tab----End---->

                                <div id="ba-target" class="tab-pane leading-relaxed" role="tabpanel"
                                    aria-labelledby="ba-tab">
                                    <div id="vertical-form" class="p-0">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('setting.store') }}" id="baForm">
                                            @csrf
                                            <input type="hidden" name="form_name" value="baForm" />
                                            <div class="preview  lg:w-1/2">
                                                <div>
                                                    <label for="ba_space_limit" class="form-label">Space Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="ba_space_limit" type="number" name="ba_space_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Space Limit" id="ba_space_limit"
                                                        value="{{ $settings['ba_space_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add space limit in
                                                        MB</span>
                                                    @error('ba_space_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mt-3">
                                                    <label for="ba_time_limit" class="form-label">Time Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="ba_time_limit" type="number" name="ba_time_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Time Limit" id="ba_time_limit"
                                                        value="{{ $settings['ba_time_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add time limit in
                                                        Minute</span>
                                                    @error('ba_time_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-primary mt-5">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!---Background Audio tab----End---->

                                <div id="ar-target" class="tab-pane leading-relaxed" role="tabpanel"
                                    aria-labelledby="ar-tab">
                                    <div id="vertical-form" class="p-0">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('setting.store') }}" id="arForm">
                                            @csrf
                                            <input type="hidden" name="form_name" value="arForm" />
                                            <div class="preview  lg:w-1/2">
                                                <div>
                                                    <label for="ar_space_limit" class="form-label">Space Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="ar_space_limit" type="number" name="ar_space_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Space Limit" id="ar_space_limit"
                                                        value="{{ $settings['ar_space_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add space limit in
                                                        MB</span>
                                                    @error('ar_space_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mt-3">
                                                    <label for="ar_time_limit" class="form-label">Time Limit<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input id="ar_time_limit" type="number" name="ar_time_limit"
                                                        autocomplete="off" class="form-control form-control-lg"
                                                        placeholder="Enter Time Limit" id="ar_time_limit"
                                                        value="{{ $settings['ar_time_limit'] ?? '' }}">
                                                    <span class="text-gray-400 mt-2 block">Please add time limit in
                                                        Minute</span>
                                                    @error('ar_time_limit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-primary mt-5">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!---Audio Record tab----End---->
                                <div id="banner-target" class="tab-pane leading-relaxed" role="tabpanel"
                                aria-labelledby="banner-tab">
                                <div id="vertical-form" class="p-0">
                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('setting.store') }}" id="bannerForm">
                                        @csrf
                                        <input type="hidden" name="form_name" value="bannerForm" />
                                        <div class="preview  lg:w-1/2">
                                            <div>
                                                <label for="banner_size" class="form-label">Banner Maximum Size<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input id="banner_size" type="number" name="banner_size"
                                                    autocomplete="off" class="form-control form-control-lg"
                                                    placeholder="Enter Maximum banner Size" id="banner_size"
                                                    value="{{ $settings['banner_size'] ?? '' }}">
                                                <span class="text-gray-400 mt-2 block">Please add banner size in
                                                    MB</span>
                                                @error('banner_size')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button class="btn btn-primary mt-5">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!---Banner tab----End---->
                            </div>
                            <!---tab--content---End---->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bbForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    bb_space_limit: {
                        required: true,
                    },
                    bb_time_limit: {
                        required: true,
                    }
                },
                messages: {
                    bb_space_limit: {
                        required: "Space limit is required.",
                    },
                    bb_time_limit: {
                        required: "Time limit is required.",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $('#baForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    ba_space_limit: {
                        required: true,
                    },
                    ba_time_limit: {
                        required: true,
                    }
                },
                messages: {
                    ba_space_limit: {
                        required: "Space limit is required.",
                    },
                    ba_time_limit: {
                        required: "Time limit is required.",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $('#arForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    ar_space_limit: {
                        required: true,
                    },
                    ar_time_limit: {
                        required: true,
                    }
                },
                messages: {
                    ar_space_limit: {
                        required: "Space limit is required.",
                    },
                    ar_time_limit: {
                        required: "Time limit is required.",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $('#bannerForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    banner_size: {
                        required: true,
                    }
                },
                messages: {
                    banner_size: {
                        required: "Banner is required.",
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

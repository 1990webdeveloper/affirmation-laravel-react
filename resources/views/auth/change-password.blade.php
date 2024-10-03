@extends('layouts.master')
@section('title', 'Change Passowrd')
@section('content')

    <div class="content">
        <div class="grid grid-cols-12 gap-3 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">
                            Change Password
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3">
            <div class="md:col-span-12 col-span-12">
                <div class="intro-y box mt-5 p-5">
                    <div id="vertical-form" class="p-0">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.change.password.submit') }}" id="changePwdForm">
                            @csrf
                            <div class="preview lg:w-1/2">
                                <div>
                                    <label for="vertical-form-1" class="form-label">Old Password<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="old_password" autocomplete="off"
                                        class="form-control form-control-lg">
                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label for="vertical-form-1" class="form-label">New Password<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="new_password" autocomplete="off"
                                        class="form-control form-control-lg">
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label for="vertical-form-1" class="form-label">Confirm New Password<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="confirm_password" autocomplete="off"
                                        class="form-control form-control-lg">
                                    @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary mt-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#changePwdForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    old_password: {
                        required: true
                    },
                    new_password: {
                        required: true
                    },
                    confirm_password: {
                        required: true
                    }
                },
                messages: {
                    old_password: {
                        required: "Old password is required.",
                    },
                    new_password: {
                        required: "New password is required.",
                    },
                    confirm_password: {
                        required: "Confirm password is required.",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

@extends('layouts.master')
@section('title', 'Category')
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ $category ? 'Category Edit' : 'Category Create' }}
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Vertical Form -->
                <div class="intro-y box">

                    <div id="vertical-form" class="p-5">
                        <form class="form-horizontal" method="POST"
                            action="{{ route('category.store', $category->id ?? '') }}" id="categoryForm">
                            @csrf
                            <input type="hidden" id="checkCategoryExist"
                                value="{{ isset($category->id) ? $category->id : old('id') }}">

                            <div class="preview  lg:w-1/2">
                                <div>
                                    <label for="vertical-form-1" class="form-label">Name<span
                                            class="text-danger">*</span></label>
                                    <input id="vertical-form-1" type="text" name="name" autocomplete="off"
                                        class="form-control form-control-lg" placeholder="Enter name"
                                        value="{{ $category ? $category->name : old('name') }}" id="inputName">
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('slug')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mt-3">
                                    <label for="vertical-form-2" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                    <textarea id="description" class="form-control" name="description">{{ $category ? $category->description : old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label id="description-error" class="text-red error hidden" for="description">This field is
                                    required.</label>
                                <span class="description-error"></span>
                                <div class="mt-3">
                                    <label>Status</label>
                                    <div class="form-switch mt-2">
                                        <input type="checkbox" value='1' name="status" class="form-check-input"
                                            {{ $category && $category->status == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
@endsection
@push('scripts')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
        $(document).ready(function() {
            var inputName = $("#inputName").val();
            $('#categoryForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                ignore: [],
                debug: false,
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                        remote: {
                            url: "{{ route('category.check.name') }}",
                            type: "post",
                            data: {
                                name: $(inputName).val(),
                                id: $('#checkCategoryExist').val(),
                                _token: "{{ csrf_token() }}"
                            },
                            dataFilter: function(data) {
                                var json = JSON.parse(data);
                                if (json.msg == "true") {
                                    return "\"" + "The name has already been taken." + "\"";
                                } else {
                                    return 'true';
                                }
                            }
                        }
                    },
                    description: {
                        required: function() {
                            CKEDITOR.instances.description.updateElement();
                        },
                        minlength: 10
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name",
                    },
                    description: {
                        required: "Please enter description",
                        minlength: "Please enter 10 characters"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

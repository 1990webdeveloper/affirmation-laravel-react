@extends('layouts.master')
@section('title', 'Banner')
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ $banner ? 'Banner Edit' : 'Banner Create' }}
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Vertical Form -->
                <div class="intro-y box">

                    <div id="vertical-form" class="p-5">
                        <form class="form-horizontal" method="POST" action="{{ route('banner.store', $banner->id ?? '') }}"
                            enctype="multipart/form-data" id="bannerForm">
                            @csrf
                            <div class="preview w-1/2">
                                <div>
                                    <label for="vertical-form-1" class="form-label">Name<span
                                            class="text-danger">*</span></label>
                                    <input id="vertical-form-1" type="text" name="name"
                                        class="form-control form-control-lg" placeholder="Enter name"
                                        value="{{ $banner ? $banner->name : old('name') }}">
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mt-3">
                                    <label for="vertical-form-2" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description">{{ $banner ? $banner->description : old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <span class="description-error"></span>
                                <div class="mt-3">
                                    @if (isset($banner))
                                        <input type="hidden" name="old_img" id="old_img" value="{{ $banner->image }}">
                                    @endif
                                    <label class="block mb-5">
                                        <label for="vertical-form-2" class="form-label">Banner<span
                                                class="text-danger">*</span></label>
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" name="banner" id="banner"
                                            class="block w-full p-1 text-md text-gray cursor-pointer form-control-lg border border-1 focus:outline-0 focus:ring-0
                                              file:mr-4 file:py-2 file:px-4
                                              file:border-0 file:cursor-pointer
                                              file:text-md file:font-medium
                                              file:bg-violet-50 file:text-gray
                                              hover:file:bg-violet-100"
                                            value="{{ $banner ? $banner->image : '' }}" />
                                        <span class="text-gray-400 mt-2 block">{{ $fileSize }} MB Maximum file size
                                            allowed</span>
                                        <span class="text-gray-400 mt-2 block">Recommended size (width: 480px - height:
                                            350px) for better quality image</span>
                                    </label>
                                    <div
                                        class="h-28 w-[150px] border border-1 relative image-fit cursor-pointer zoom-in preview-image {{ $banner ? '' : 'hidden' }}">
                                        <img class="rounded-md object-cover p-2" alt="Preview image"
                                            id="preview-image-before-upload"
                                            src="{{ $banner ? asset('storage/banner/' . $banner->image) : '' }}">
                                    </div>
                                </div>
                                @error('banner')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mt-3">
                                    <label>Status</label>
                                    <div class="form-switch mt-2">
                                        <input type="checkbox" value='1' name="status" class="form-check-input"
                                            {{ $banner && $banner->status == '1' ? 'checked' : '' }}>
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
    <script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var _URL = window.URL || window.webkitURL;
            var img_width = "";
            var img_height = "";

            $('#banner').change(function() {
                $('.preview-image').removeClass('hidden');
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#banner').change(function() {
                var file, img;
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {
                        img_width = this.width;
                        img_height = this.height;
                    };
                    img.src = _URL.createObjectURL(file);
                }
            });
            var fileSize = @json($fileSize);
            var fileSizeKb = (fileSize * 1024 * 1024); //MB to Bytes

            // $.validator.addMethod('dimention', function(value, element, param) {
            //     if (param == true && img_width != '') {
            //         if (img_width == 480 && img_height == 350) {
            //             return true;
            //         } else {
            //             return false;
            //         }
            //     } else {
            //         return true;
            //     }
            // }, '');
            $('#bannerForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    name: {
                        required: true,
                    },
                    description: {
                        required: true,
                        maxlength: 500,
                        minlength: 10,
                    },
                    banner: {
                        required: function() {
                            return $('#old_img').val() == undefined ? true : false;
                        },
                        extension: "png|jpg|jpeg",
                        fileSizeLimit: fileSizeKb,
                    }
                },
                messages: {
                    name: {
                        required: "Name is required.",
                    },
                    description: {
                        required: "Description is required.",
                    },
                    banner: {
                        required: "Banner is required.",
                        extension: "Please upload file in these format only (png,jpg,jpeg).",
                        dimention: "Please upload recommended size banner."
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $.validator.addMethod('fileSizeLimit', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'Maximum file size is ' + fileSize + ' MB');
        });
    </script>
@endpush

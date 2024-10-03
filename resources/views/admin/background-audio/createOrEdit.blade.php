@extends('layouts.master')
@section('title', 'Background Audio')
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ $backgroundAudio ? 'Background Audio Edit' : 'Background Audio Create' }}
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Vertical Form -->
                <div class="intro-y box">

                    <div id="vertical-form" class="p-5">
                        <form class="form-horizontal" method="POST"
                            action="{{ route('background-audio.store', $backgroundAudio->id ?? '') }}"
                            enctype="multipart/form-data" id="baForm">
                            @csrf
                            <div class="preview lg:w-1/2">
                                <div>
                                    <label for="vertical-form-1" class="form-label">Name<span
                                            class="text-danger">*</span></label>
                                    <input id="vertical-form-1" type="text" name="name" class="form-control"
                                        placeholder="Enter name" autocomplete="off"
                                        value="{{ $backgroundAudio ? $backgroundAudio->name : old('name') }}">
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mt-3">
                                    <label for="vertical-form-2" class="form-label">Uplaod Audio File<span
                                            class="text-danger">*</span></label>
                                    @if (isset($backgroundAudio))
                                        <input type="hidden" name="old_audio" id="old_audio" value="{{ $backgroundAudio->audio_path }}">
                                    @endif

                                    <label class="block mb-5">
                                        <span class="sr-only">Choose background audio</span>
                                        <input type="file" name="audio_path" id="audioFile"
                                            class="block w-full p-1 text-md text-gray cursor-pointer form-control-lg border border-1 focus:outline-0 focus:ring-0
                                              file:mr-4 file:py-2 file:px-4
                                              file:border-0 file:cursor-pointer
                                              file:text-md file:font-medium
                                              file:bg-violet-50 file:text-gray
                                              hover:file:bg-violet-100"
                                            value="{{ $backgroundAudio ? $backgroundAudio->audio_path : '' }}" />
                                        <span class="text-gray-400 mt-2 block">Recommended audio file size is:
                                            {{ $spaceLimit }} MB and {{ $timeLimit }} Minute</span>
                                    </label>
                                    @if (isset($backgroundAudio))
                                        <audio id="audioPreview"
                                            src="{{ asset('storage/background-audio/audio/' . $backgroundAudio->audio_path) }}"
                                            controls></audio>
                                    @else
                                        <audio id="audioPreview" controls></audio>
                                    @endif
                                </div>
                                @error('audio_path')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="mt-4">
                                    <label>Status</label>
                                    <div class="form-switch mt-2">
                                        <input type="checkbox" value='1' name="status" class="form-check-input"
                                            {{ $backgroundAudio && $backgroundAudio->status == '1' ? 'checked' : '' }}>
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
    <script>
        $(document).ready(function() {
            var audioPreview = document.getElementById('audioPreview');
            var duration = 0;
            document.getElementById('audioFile').addEventListener('change', function(e) {
                var audioFile = e.target.files[0];

                if (audioFile) {
                    // Set the source of the audio element to the selected file
                    audioPreview.src = URL.createObjectURL(audioFile);
                    audioPreview.onloadedmetadata = function() {
                        duration = audioPreview.duration;
                    };
                } else {
                    // If no file selected, clear the audio preview
                    audioPreview.src = '';
                }
            });

            var spaceLimit = @json($spaceLimit);
            var spaceLimitByte = (spaceLimit * 1024 * 1024); //MB to Bytes
            var timeLimit = @json($timeLimit);
            var timeLimitSecond = (timeLimit * 60); //Min to Second

            $('#baForm').validate({
                errorClass: "text-red error",
                validClass: "valid success-alert",
                rules: {
                    name: {
                        required: true
                    },
                    audio_path: {
                        required: function() {
                            return $('#old_audio').val() == undefined ? true : false;
                        },
                        extension: "mpeg|mp3|wav|aac",
                        spaceLimit: spaceLimitByte,
                        timeLimit: function() {
                            return timeLimitSecond + ',' + duration;
                        }
                    }
                },
                messages: {
                    name: {
                        required: "Name is required.",
                    },
                    audio_path: {
                        required: "Background audio is required.",
                        extension: "Please upload file in these format only (mpeg,mp3,wav,aac)."
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $.validator.addMethod('spaceLimit', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param)
            }, 'Maximum space limit is ' + spaceLimit + ' MB');

            $.validator.addMethod('timeLimit', function(value, element, param) {
                const arr = param.split(",");
                return (parseInt(arr[1]) <= parseInt(arr[0]));
            }, 'Maximum time limit is ' + timeLimit + ' Minute');
        });
    </script>
@endpush

@extends('layouts.app')

@section('head')
    @vite(['resources/js/background-drop-audio.js'])
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ucfirst(__('multimedia.audio.create-title')) }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form id="audioBackground_form" method="POST" enctype="multipart/form-data" action="{{ route('audioBackground.store') }}">
                            @csrf
                            <div class="col">
                                <div class="row">
                                    <div class="form-outline">
                                        <label class="form-label" for="name">{{ ucfirst(__('multimedia.name')) }}</label>
                                        <input id="name" name="name" class="form-control" type="text" placeholder="{{ucfirst(__('multimedia.audio.placeholders.name'))}}">
                                    </div>
                                </div>

                            </div>

                    <div class="row mb-4">
                        <div class="col">

                        </div>
                    </div>

                    <div class="row mb-4 audio-container">
                        <div class="container mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <div id="audio-drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                         style="height: 200px; cursor: pointer">
                                        <div class="text-center">
                                            <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                            <p class="mt-3">
                                                {{ ucfirst(__('media.audio.drag-and-drop')) }}
                                            </p>
                                        </div>
                                    </div>
                                    <input type="file" name="background_audio" id="background_audio" accept="audio/*" class="d-none" />
                                    @error('background_audio')
                                    <div class="text-danger">{{ __($message) }}</div>
                                    @enderror
                                    <div id="audio-preview" class="container"></div>
                                </div>
                            </div>
                        </div>
                        <audio id="audio" controls="controls">
                            <source id="audioSource" src="">
                        </audio>

                    </div>

                    <!-- Submit button -->
                    <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb">{{ ucfirst(__('multimedia.save')) }}</button>
                    <hr class="hr mb-4" />
                    </form>

                </div>
            </div>

        </div>
    </div>


    </div>
@endsection

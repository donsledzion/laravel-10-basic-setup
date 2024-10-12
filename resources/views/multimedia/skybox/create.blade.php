@extends('layouts.app')

@section('head')
    @vite(['resources/js/skybox-drop-texture.js','resources/js/skybox-drop-thumbnail.js'])
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ucfirst(__('multimedia.skybox.add')) }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form id="skyboxBackground_form" method="POST" action="{{ route('skyboxBackground.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- 2 column grid layout with text inputs for organization name and prefix -->
                            <div class="row mb-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="name">{{ ucfirst(__('multimedia.name')) }}</label>
                                        <input id="name" name="name" class="form-control" type="text" placeholder="{{ucfirst(__('multimedia.skybox.placeholders.name'))}}">
                                        @error('name')
                                        <div class="text-danger">{{ __($message) }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 texture-container">
                                <div class="container mt-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="texture-drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                                 style="height: 200px; cursor: pointer">
                                                <div class="text-center">
                                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                                    <p class="mt-3">
                                                        {{ ucfirst(__('multimedia.skybox.drop.texture')) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <input type="file" name="texture" id="texture" multiple accept="image/*" class="d-none" />
                                            @error('logo')
                                            <div class="text-danger">{{ __($message) }}</div>
                                            @enderror
                                            <div id="texture-gallery" class="container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 thumbnail-container">
                                <div class="container mt-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="thumbnail-drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                                 style="height: 200px; cursor: pointer">
                                                <div class="text-center">
                                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                                    <p class="mt-3">
                                                        {{ ucfirst(__('multimedia.skybox.drop.thumbnail')) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <input type="file" name="thumbnail" id="thumbnail" multiple accept="image/*" class="d-none" />
                                            @error('logo')
                                            <div class="text-danger">{{ __($message) }}</div>
                                            @enderror
                                            <div id="thumbnail-gallery" class="container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('organization.create')) }}</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $('#expires_at').datepicker({
            format: 'yyyy/mm/dd',
            uiLibrary: 'bootstrap5'
        });

    </script>
@endsection

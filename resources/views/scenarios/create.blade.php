@extends('layouts.app')

@section('head')
    @vite(['resources/js/organization-drop-logo.js'])
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('scenario.form.creation')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('scenario.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-0">
                          <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old("name") }}" placeholder="{{ __('scenario.placeholder.name') }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('scenario.name')) }}</label>
                                      @error('name')
                                          <div class="text-danger">{{ __($message) }}</div>
                                      @enderror
                                  </div>
                            </div>
                            <div class="row mb-4 mt-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                      <input type="password" id="pin" name="pin" class="form-control" placeholder="{{ __('scenario.placeholder.pin') }}" value="{{ old('pin') }}"/>
                                      <label class="form-label" for="pin">{{ ucfirst(__('scenario.pin')) }}</label>
                                        @error('pin')
                                            <div class="text-danger">{{ __($message) }}</div>
                                        @enderror
                                    </div>
                                  </div>
                            </div>

                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <textarea id="description" rows="5" name="description" class="form-control" placeholder="{{ __('scenario.placeholder.description') }}">{{ old("description") }}</textarea>
                              <label class="form-label" for="description">{{ ucfirst(__('scenario.description')) }}</label>
                                @error('description')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-0">
                            @isset($organization)
                            <input type="text" name="organization_id" value="{{ $organization->id }}"  style="display: none;" >
                            @else
                            @endisset

                        </div>

                            <div class="row mb-4">
                                <label for="interaction_id">Rodzaj interakcji z zadaniami:</label>
                                <select id="interaction_id" name="interaction_id" class="form-select">
                                    @foreach(\App\Models\AnsweringInteractionType::all() as $interaction)
                                        <option value="{{$interaction->id}}">{{$interaction->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-4">
                                <label for="audio_background_id">Tło muzyczne:</label>
                                <select id="audio_background_id" name="audio_background_id" class="form-select">
                                        <option value="{{null}}">{{__('multimedia.none')}}</option>
                                    @foreach(\App\Models\AudioBackground::all() as $audio)
                                        <option value="{{$audio->id}}">{{$audio->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-4">
                                Zestaw kolorów:
                                <label for="favcolor">Kolor tekstu pytania:</label>
                                <input type="color" id="color_question_text" name="color_question_text" value="#000000">
                                <label for="favcolor">Kolor tekstu odpowiedzi:</label>
                                <input type="color" id="color_answer_text" name="color_answer_text" value="#ffffff">
                                <label for="favcolor">Kolor tła pytania:</label>
                                <input type="color" id="color_question_background" name="color_question_background" value="#000000">
                                <label for="favcolor">Kolor tła odpowiedzi:</label>
                                <input type="color" id="color_answer_background" name="color_answer_background" value="#ffffff">
                                <label for="favcolor">Kolor podłogi:</label>
                                <input type="color" id="color_floor" name="color_floor" value="#ffffff">
                            </div>
                        <div class="row mb-4 logo-container">
                            <div class="container mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="logo-drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                             style="height: 200px; cursor: pointer">
                                            <div class="text-center">
                                                <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                                <p class="mt-3">
                                                    {{ ucfirst(__('scenario.logo.drop')) }}
                                                </p>
                                            </div>
                                        </div>
                                        <input type="file" name="logo" id="logo" multiple accept="image/*" class="d-none" />
                                        @error('logo')
                                        <div class="text-danger">{{ __($message) }}</div>
                                        @enderror
                                        <div id="gallery" class="container"></div>
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
@endsection

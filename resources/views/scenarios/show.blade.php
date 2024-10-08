@extends('layouts.app')

@section('head')
@vite(['resources/js/scenario-remove-quiz.js','resources/js/toggle-pin-text.js'])
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: none; }
    a:active { text-decoration: none; }
    </style>
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">{{ ucfirst(__('scenario.form.show')) }}</div>
                        <div class="col text-end">
                            <a href="{{ route('organization.show',$scenario->organization) }}">
                                <button class="btn btn-info py-2 px-2 fa-solid fa-rotate-left"></button>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- 2 column grid layout with text inputs for organization name and prefix -->
                    <div class="row mb-4">
                        <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="name">{{ ucfirst(__('scenario.author')) }}</label>
                                    @if(!empty($scenario->owner->name))
                                        <p><strong>{{ $scenario->owner->name }}</strong></p>
                                    @else
                                        <p><strong>{{ $scenario->owner->email }}</strong></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="name">{{ ucfirst(__('scenario.name')) }}</label>
                                    <p><strong>{{ $scenario->name }}</strong></p>
                                </div>
                            </div>
                            <div class="row mb-4 mt-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="pin">{{ ucfirst(__('scenario.pin')) }}</label>
                                        @if($scenario->pin)
                                        <p id="pin" style="display: none;">{{ $scenario->pin }}</p>
                                        <p id="pin-hidden">
                                            @for($i = 0 ; $i < strlen($scenario->pin) ; $i++)
                                            *
                                            @endfor
                                        </p>
                                        @else
                                        <p>{{ __('scenario.none') }}</p>
                                        @endif
                                    </div>
                                    <i class="fa-regular fa-eye-slash toggle-password" style="cursor: pointer;"></i>
                                    </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border-end">
                                @if(!empty($scenario->logo) && \Illuminate\Support\Facades\Storage::exists('multimedia/'.$scenario->organization->id.'/pictures/'.$scenario->logo))
                                    <img src="{{ asset('organizations'.'/'.$scenario->organization->id.'/pictures/'.$scenario->logo) }}" class="img-fluid avatar-xxl rounded" alt="">
                                @else
                                    <img src="{{ asset('organizations'.'/'.$scenario->organization->id.'/pictures/'.$scenario->organization->logo) }}" class="img-fluid avatar-xxl rounded" alt="">
                                @endif
                            </div>
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label" for="description">{{ ucfirst(__('scenario.description')) }}</label>
                            <p id="description" name="description" class="text">{{ $scenario->description }}</p>
                        </div>
                        </div>
                    </div>

                    <!-- 2 column grid layout with text inputs for organization name and prefix -->
                    <div class="row mb-4">

                    </div>


                    <!-- Submit button -->

                </div>
                <a href="{{ route('scenario.edit',[$scenario]) }}" data-mdb-ripple-init type="button" class="btn btn-warning btn-block mb-4">{{ ucfirst(__('scenario.edit')) }}</a>

            </div>

            <div class="card mt-2">
                <div class="card-header">{{ ucfirst(__('quiz.quizzes')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- 2 column grid layout with text inputs for organization name and prefix -->
                    <div class="row mb-4">
                        <a href="{{ route('quiz.create',[$scenario]) }}" class="btn btn-success">{{ ucfirst(__('quiz.add')) }}</a>
                    </div>
                    @foreach ($scenario->quizzes as $quiz)
                        @include('scenarios.components.quiz',[$quiz])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

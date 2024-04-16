@extends('layouts.app')

@section('head')
@if($quiz->type == \App\Enums\QuizTypes::TEXT_2_PICTURE)
    @vite(['resources/js/answer-drop-picture.js','resources/js/quiz-correct.js']);
@elseif($quiz->type == \App\Enums\QuizTypes::TEXT_2_AUDIO || $quiz->type == \App\Enums\QuizTypes::AUDIO_2_AUDIO)
    @vite(['resources/js/answer-drop-audio.js','resources/js/quiz-correct.js']);
@elseif($quiz->type == \App\Enums\QuizTypes::PUT_IN_ORDER)

@else
    @vite(['resources/js/quiz-correct.js']);
@endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">                
                <div class="card-header">
                    <div class="row">
                        <div class="col">{{ ucfirst(__('quiz.show.title')) }}</div>
                        <div class="col text-end"><a href="{{ route('scenario.show',$quiz->scenario) }}" class="fa-solid fa-rotate-left">powrót</a></div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col">
                        <div class="row">
                            <div class="form-outline">
                            <label class="form-label" >{{ ucfirst(__('quiz.type')) }}: </label>
                            <span><strong>{{ ucfirst(__('quiz.types.'.$quiz->type->value)) }}</strong></span>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-outline">
                            <label class="form-label" for="question_text">{{ ucfirst(__('quiz.form.question_text')) }}: </label>
                            <span><strong>{{ $quiz->question_text }}</strong></span>
                        </div>
                        
                        </div>
                    </div>
                    <div class="row mb-4">
                        @if($quiz->questionFileMediaType() == \App\Enums\MediaTypes::PICTURE)
                            @include('quizzes.components.question-picture',['quiz' => $quiz])
                        @elseif($quiz->questionFileMediaType() == \App\Enums\MediaTypes::AUDIO)
                            @include('quizzes.components.question-audio',['quiz' => $quiz])
                        @endif
                    </div>                
                    <hr class="hr mb-4" />
                        
                    <div class="row mb-4">
                        <strong>Odpowiedzi:</strong>
                        <div class="col">                                
                            @foreach ($quiz->answers as $answer)
                                @include('quizzes.components.answer',['answer' => $answer])
                            @endforeach  
                        </div>
                    </div>
                    
                    <p>                        
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            {{ ucfirst(__('quiz.answer.add')) }}
                        </button>
                    </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <form method="POST" action="{{ route('answer.store',[$quiz]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @if($quiz->type == \App\Enums\QuizTypes::TEXT_2_PICTURE)
                                        @include('quizzes.components.answers.content-picture')
                                    @elseif($quiz->type == \App\Enums\QuizTypes::TEXT_2_AUDIO ||$quiz->type == \App\Enums\QuizTypes::AUDIO_2_AUDIO)
                                        @include('quizzes.components.answers.content-audio')                                    
                                    @else                                    
                                        @include('quizzes.components.answers.content-text')                                    
                                    @endif
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_correct" name="is_correct" value="1" checked>
                                        <label class="form-check-label" for="is_correct">{{ __('quiz.answer.is_correct') }}</label>
                                        @error('is_correct')
                                            <div class="text-danger">{{ __($message) }}</div>
                                        @enderror
                                    </div>
                                    <button data-mdb-ripple-init type="submit" class="btn btn-warning btn-block mb mt-2 new-answer">{{ ucfirst(__('quiz.save')) }}</button>           
                                </form>
                            </div>
                        </div>                           
                    </div>
                    <hr class="hr mb-4" />
            </div>            
        </div>
    </div>    
</div>
@endsection
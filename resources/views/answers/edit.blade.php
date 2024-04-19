@extends('layouts.app')
@section('head')
@if($answer->quiz->type == \App\Enums\QuizTypes::TEXT_2_PICTURE)
    @vite(['resources/js/answer-drop-picture.js','resources/js/quiz-correct.js']);
@elseif($answer->quiz->type == \App\Enums\QuizTypes::TEXT_2_AUDIO || $answer->quiz->type == \App\Enums\QuizTypes::AUDIO_2_AUDIO)
    @vite(['resources/js/answer-drop-audio.js','resources/js/quiz-correct.js']);
@elseif($answer->quiz->type == \App\Enums\QuizTypes::PUT_IN_ORDER)

@else
    @vite(['resources/js/quiz-correct.js'])
@endif
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('answer.edit-form')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('answer.update',$answer) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                    
                        @if($answer->quiz->type == \App\Enums\QuizTypes::TEXT_2_PICTURE)
                            @include('answers.components.edit.content-picture')
                        @elseif($answer->quiz->type == \App\Enums\QuizTypes::TEXT_2_AUDIO ||$answer->quiz->type == \App\Enums\QuizTypes::AUDIO_2_AUDIO)
                            @include('answers.components.edit.content-audio',['answer' => $answer])                                    
                        @else                                    
                            @include('answers.components.edit.content-text',['answer' => $answer])                                    
                        @endif
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_correct" name="is_correct" value="1" @if($answer->is_correct == true) checked @endif>
                            <label class="form-check-label" for="is_correct">{{ __('quiz.answer.is_correct') }}</label>
                            @error('is_correct')
                                <div class="text-danger">{{ __($message) }}</div>
                            @enderror
                        </div>
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('answer.update')) }}</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
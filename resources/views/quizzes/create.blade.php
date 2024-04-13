@extends('layouts.app')

@section('head')
@vite(['resources/js/quiz-drop-audio.js','resources/js/quiz-drop-picture.js','resources/js/quiz-select-type.js'])
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('quiz.create.title')) }}: <i>"{{ $scenario->name }}"</i></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="quiz_form" method="POST" enctype="multipart/form-data" action="{{ route('quiz.store',[$scenario]) }}">
                        @csrf                        
                        <div class="col">
                            <div class="row">
                                <div class="form-outline">
                                <label class="form-label" for="role">{{ ucfirst(__('quiz.type')) }}</label>
                                <div class="col-10">
                                    <select id="type" name="type" class="form-select mx-2">
                                        @foreach(\App\Enums\QuizTypes::cases() as $type)
                                            <option value="{{ $type->value }}" @if( old('type') == $type->value) selected @endif>{{ ucfirst(__('quiz.types.'.$type->value)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-outline">
                                <label class="form-label" for="question_text">{{ ucfirst(__('quiz.form.question_text')) }}</label>
                                <input type="text" id="question_text" name="question_text" class="form-control" value="{{ old('question_text') }}"  />
                                    @error('question_text')
                                        <div class="text-danger">{{ __($message) }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                          </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col">                                
                                
                            </div>
                        </div>
                        <div class="row mb-4 picture-container" style="display: none;">
                            <div class="container mt-5">
                                <div class="card">
                                  <div class="card-body">
                                    <div id="picture-drop-area" class="border rounded d-flex justify-content-center align-items-center"
                                      style="height: 200px; cursor: pointer">
                                      <div class="text-center">
                                        <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                                        <p class="mt-3">
                                          {{ ucfirst(__('media.picture.drag-and-drop')) }}
                                        </p>
                                      </div>
                                    </div>
                                    <input type="file" name="question_picture" id="question_picture" multiple accept="image/*" class="d-none" disabled />
                                    @error('question_picture')
                                        <div class="text-danger">{{ __($message) }}</div>
                                    @enderror
                                    <div id="gallery" class="container"></div>
                                  </div>
                                </div>
                              </div>
                        </div>

                        <div class="row mb-4 audio-container" style="display: none;">
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
                                    <input type="file" name="question_audio" id="question_audio" multiple accept="audio/*" class="d-none" disabled/>
                                    @error('question_audio')
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
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb">{{ ucfirst(__('quiz.save')) }}</button>
                        <hr class="hr mb-4" />
                      </form>
                      
                </div>
            </div>
@include('quizzes.components.answers.text2text')
            
        </div>
    </div>    
    
    
</div>
@endsection
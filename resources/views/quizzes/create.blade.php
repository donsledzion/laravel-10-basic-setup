@extends('layouts.app')

@section('head')
@vite(['resources/js/quiz.js'])
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

                    <form id="quiz_form" method="POST" action="{{ route('quiz.store',[$scenario]) }}">
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
                                <input type="text" id="question_text" name="question_text" class="form-control" value="{{ old('question_text') }}" />
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
@section('javascript')
 
</script>
@endsection
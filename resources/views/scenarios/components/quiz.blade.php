<div class="row my-1" >
    <div class="col-xl-12">        
        <div class="card task-box rounded-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-sm-5">
                        <div class="checklist form-check font-size-15">
                            <div class="row">                                  
                                <div class="col">
                                    <a href="{{ route('quiz.show',[$quiz]) }}">
                                    <label class="form-check-label ms-1 task-title">{{ $quiz->question_text }}</label>                                
                                    </a>
                                </div>
                                <div class="col text-end">
                                    <div class="row">
                                        <div class="col">
                                            @include('quizzes.components.quiz-type',['quiz' => $quiz])
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-warning"><a href="{{ route('quiz.edit',$quiz) }}" style="text-decoration: none;"><i class="fa-regular fa-pen-to-square"></i></a><button>
                                            <button class="btn btn-danger delete-quiz" data-id="{{ $quiz->id }}" >
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->                    
                </div><!-- end row -->
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
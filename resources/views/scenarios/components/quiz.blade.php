<div class="row my-1" >
    <div class="col-xl-12">        
        <div id="task-item-1">
            <div class="card task-box rounded-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-sm-5">
                            <div class="checklist form-check font-size-15">
                                <a href="{{ route('quiz.show',[$quiz]) }}">
                                    <label class="form-check-label ms-1 task-title">{{ $quiz->question_text }}</label>
                                </a>
                            </div>
                        </div><!-- end col -->
                        
                    </div><!-- end row -->
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div><!-- end col -->
</div><!-- end row -->
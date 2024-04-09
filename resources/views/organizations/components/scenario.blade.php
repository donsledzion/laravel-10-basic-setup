<div class="row">
    <div class="col-xl-12">
        <div class="task-list-box" id="landing-task">
            <div id="task-item-1">
                <div class="card task-box rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-sm-5">
                                <div class="checklist form-check font-size-15">
                                    <!-- <input type="checkbox" class="form-check-input" id="customCheck1"> -->
                                    <a href="{{ route('scenario.show',[$scenario]) }}">
                                        <label class="form-check-label ms-1 task-title" for="customCheck1">{{ $scenario->name }}</label>
                                    </a>
                                </div>
                            </div><!-- end col -->
                            
                        </div><!-- end row -->
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div>
        </div><!-- end -->

    </div><!-- end col -->
</div><!-- end row -->
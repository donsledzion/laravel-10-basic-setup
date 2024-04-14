<div class="row">
    <div class="col-xl-12">
        <div>
            <div>
                <div class="card rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-xl-12 col-sm-5">
                                <div class="font-size-15">
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ route('scenario.show',[$scenario]) }}">
                                                <label class="form-check-label ms-1">{{ $scenario->name }}</label>                                        
                                            </a>
                                        </div>
                                        <div class="col text-end">
                                            <button class="btn btn-danger delete-scenario" data-id="{{ $scenario->id }}" >{{ ucfirst(__('quiz.buttons.delete')) }}</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div><!-- end col -->
                            
                        </div><!-- end row -->
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div>
        </div><!-- end -->

    </div><!-- end col -->
</div><!-- end row -->
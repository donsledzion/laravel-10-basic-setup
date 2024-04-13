<div class="row">
    <div class="col-xl-12">
        <div class="task-list-box" id="landing-task">
            <div id="task-item-1">
                <div class="card task-box rounded-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-sm-5">
                                <div class="list font-size-15">
                                    <span><strong>{{ $user->name }} - {{ $user->email }} - {{ ucfirst(__('user.roles.'.\App\Models\Role::find($user->pivot->role_id)->name)) }} </strong></span>
                                </div>
                            </div><!-- end col -->

                        </div><!-- end row -->
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div>
        </div><!-- end -->

    </div><!-- end col -->
</div><!-- end row -->

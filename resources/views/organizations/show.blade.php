@extends('layouts.app')
@section('head')
<style>

    body{
   margin-top:20px;
   background:#f7f8fa
}

.avatar-xxl {
    height: 7rem;
    width: 7rem;
}

.card {
    margin-bottom: 20px;
    -webkit-box-shadow: 0 2px 3px #eaedf2;
    box-shadow: 0 2px 3px #eaedf2;
}

.pb-0 {
    padding-bottom: 0!important;
}

.font-size-16 {
    font-size: 16px!important;
}
.avatar-title {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background-color: #038edc;
    color: #fff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-weight: 500;
    height: 100%;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 100%;
}

.bg-soft-primary {
    background-color: rgba(3,142,220,.15)!important;
}
.rounded-circle {
    border-radius: 50%!important;
}

.nav-tabs-custom .nav-item .nav-link.active {
    color: #038edc;
}
.nav-tabs-custom .nav-item .nav-link {
    border: none;
}
.nav-tabs-custom .nav-item .nav-link.active {
    color: #038edc;
}

.avatar-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 12px;
}

.border-end {
    border-right: 1px solid #eff0f2 !important;
}

.d-inline-block {
    display: inline-block!important;
}

.badge-soft-danger {
    color: #f34e4e;
    background-color: rgba(243,78,78,.1);
}

.badge-soft-warning {
    color: #f7cc53;
    background-color: rgba(247,204,83,.1);
}

.badge-soft-success {
    color: #51d28c;
    background-color: rgba(81,210,140,.1);
}

.avatar-group .avatar-group-item {
    margin-left: -14px;
    border: 2px solid #fff;
    border-radius: 50%;
    -webkit-transition: all .2s;
    transition: all .2s;
}

.avatar-sm {
    height: 2rem;
    width: 2rem;
}

.nav-tabs-custom .nav-item {
    position: relative;
    color: #343a40;
}

.nav-tabs-custom .nav-item .nav-link.active:after {
    -webkit-transform: scale(1);
    transform: scale(1);
}

.nav-tabs-custom .nav-item .nav-link::after {
    content: "";
    background: #038edc;
    height: 2px;
    position: absolute;
    width: 100%;
    left: 0;
    bottom: -2px;
    -webkit-transition: all 250ms ease 0s;
    transition: all 250ms ease 0s;
    -webkit-transform: scale(0);
    transform: scale(0);
}

.badge-soft-secondary {
    color: #74788d;
    background-color: rgba(116,120,141,.1);
}

.badge-soft-secondary {
    color: #74788d;
}

.work-activity {
    position: relative;
    color: #74788d;
    padding-left: 5.5rem
}

.work-activity::before {
    content: "";
    position: absolute;
    height: 100%;
    top: 0;
    left: 66px;
    border-left: 1px solid rgba(3,142,220,.25)
}

.work-activity .work-item {
    position: relative;
    border-bottom: 2px dashed #eff0f2;
    margin-bottom: 14px
}

.work-activity .work-item:last-of-type {
    padding-bottom: 0;
    margin-bottom: 0;
    border: none
}

.work-activity .work-item::after,.work-activity .work-item::before {
    position: absolute;
    display: block
}

.work-activity .work-item::before {
    content: attr(data-date);
    left: -157px;
    top: -3px;
    text-align: right;
    font-weight: 500;
    color: #74788d;
    font-size: 12px;
    min-width: 120px
}

.work-activity .work-item::after {
    content: "";
    width: 10px;
    height: 10px;
    border-radius: 50%;
    left: -26px;
    top: 3px;
    background-color: #fff;
    border: 2px solid #038edc
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('organization.card')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body pb-0">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="text-center border-end">
                            <img src="{{ $organization->logo }}" class="img-fluid avatar-xxl rounded-circle" alt="">
                        </div>
                    </div><!-- end col -->
                    <div class="col-md-9">
                        <div class="ms-3">
                            <div>
                                <h4 class="card-title mb-2">{{ $organization->name }}</h4>
                                <h5>{{ __('organization.prefix') }}: {{ $organization->prefix }}</h5>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div>
                                        <label>{{ ucfirst(__('user.roles.manager')) }}:</label>
                                        @if($organization->managers()->count() < 1)
                                        <p class="text-strong mb-2 fw-medium text-danger">
                                            <i class="mdi mdi-email-outline me-2"></i>
                                            <strong>{{ ucfirst(__('user.roles.none')) }}</strong>
                                        </p>
                                        @endif
                                        @foreach($organization->managers() as $manager)
                                            <p class="text-strong mb-2 fw-medium">
                                                <i class="mdi mdi-email-outline me-2"></i>
                                                <strong>{{ $manager->name }}</strong>
                                            </p>
                                        @endforeach
                                        <label>{{ ucfirst(__('organization.expires_at')) }}</label>
                                        <p class="fw-medium mb-0"><i class="mdi mdi-phone-in-talk-outline me-2"></i><strong>{{ $organization->expires_at->format("d-m-Y") }}</strong>
                                        </p>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
            <a href="{{ route('organization.edit',[$organization]) }}" class="btn btn-warning">{{ ucfirst(__('organization.edit')) }}</a>
        </div><!-- end card -->

        <div class="card">
            <h4 class="card-title mb-4">{{ ucfirst(__('organization.members.members')) }}</h4>
            <a href="{{ route('organization.create.manager',[$organization]) }}" class="btn btn-info">{{ ucfirst(__('organization.members.add.manager')) }}</a>
            <a href="{{ route('organization.create.trainer',[$organization]) }}" class="btn btn-success mt-1">{{ ucfirst(__('organization.members.add.trainer')) }}</a>
            <div class="tab-content p-4">
                

                <div class="tab-panel active show" id="tasks-tab" role="tabpanel">    
                    @foreach($organization->users as $user)
                        @include('organizations.components.member',['user' => $user])
                    @endforeach
                </div><!-- end tab pane -->

                
            </div>
        </div><!-- end card -->

        <div class="card">
            <h4 class="card-title mb-4">{{ ucfirst(__('organization.scenarios.scenarios')) }}</h4>
            <a href="{{ route('scenario.create',[$organization]) }}" class="btn btn-info">{{ ucfirst(__('organization.scenarios.add')) }}</a>
            <div class="tab-content p-4">
                

                <div class="tab-pane active show" id="tasks-tab" role="tabpanel">
                    
                    
                    
                    @foreach($organization->scenarios() as $scenario)
                        @include('organizations.components.scenario',['scenario' => $scenario])
                    @endforeach
                </div><!-- end tab pane -->

                
            </div>
        </div><!-- end card -->
    </div><!-- end col -->
</div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


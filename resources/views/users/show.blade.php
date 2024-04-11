@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('user.card.card')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <label >{{ ucfirst(__('user.card.name')) }}</label></br>
                                    @if(empty($user->name))
                                        <span class="text-danger"><strong>{{ __('user.roles.none')}}</strong></span>  
                                    @else
                                        <span><strong>{{ $user->name}}</strong></span>  
                                    @endif
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <label >{{ ucfirst(__('user.card.email')) }}</label></br>
                                <span><strong>{{ $user->email}}</strong></span>                              
                            </div>
                          </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col">
                                <div data-mdb-input-init class="form-outline">
                                    <label >{{ ucfirst(__('user.card.role')) }}</label></br>
                                    <span><strong>{{ ucfirst(__('user.roles.'.$user->role->value))}}</strong></span>                              
                                </div>
                            </div>
                        </div>
                      
                        <!-- Submit button -->
                        <a href="{{ route('user.edit',[$user]) }}"><button data-mdb-ripple-init type="button" class="btn btn-warning btn-block mb-4">{{ ucfirst(__('user.edit')) }}</button></a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
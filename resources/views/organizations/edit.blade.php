@extends('layouts.app')

@section('head')
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('organization.add')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('organization.update',[$organization]) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="name" name="name" class="form-control" value="{{ old("name", $organization->name) }}" />
                              <label class="form-label" for="name">{{ ucfirst(__('organization.name')) }}</label>
                                @error('name')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="prefix" name="prefix" class="form-control" value="{{ old("prefix", $organization->prefix) }}" />
                              <label class="form-label" for="prefix">{{ ucfirst(__('organization.prefix')) }}</label>
                                @error('prefix')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="headset_login" name="headset_login" class="form-control" value="{{ old("headset_login", $organization->headset_login) }}" />
                              <label class="form-label" for="headset_login">{{ ucfirst(__('organization.headset.login')) }}</label>
                              @error('headset_login')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>                          
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              @if(\Auth::user()->isOrganizationAdmin($organization))
                              <input type="password" id="headset_pin" name="headset_pin" class="form-control" placeholder="organization.placeholder.pin" value="{{ old('headset_pin', $organization->headset_pin) }}"/>
                              <label class="form-label" for="headset_pin">{{ ucfirst(__('organization.headset.pin')) }}</label>
                                @error('headset_pin')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                              @else
                              <input type="password" class="form-control" placeholder="organization.placeholder.pin" value="{{ $organization->headset_pin }}" disabled />
                              <label class="form-label" for="headset_pin">{{ ucfirst(__('organization.headset.pin')) }}</label>
                              @endif
                            </div>
                          </div>
                        </div>

                        @if(\Auth::user()->isAdmin())
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input id="expires_at" name="expires_at" width="276" value="{{ old("expires_at", $organization->expires_at) }}" />
                            <label class="form-label" for="expires_at">{{ ucfirst(__('organization.expires_at')) }}</label>
                              @error('expires_at')
                                <div class="text-danger">{{ __($message) }}</div>
                              @enderror
                        </div>
                        @endif

                        <div class="container my-5">
                          <div class="card-body">
                            <div>
                              <input type="file" id="logo" name="logo" accept="image/*" />
                              @error('logo')
                                <div class="text-danger">{{ __($message) }}</div>
                              @enderror
                            </div>     
                            <div>
                              <img src="{{ asset('organizations'.'/'.$organization->id.'/pictures/'.$organization->logo) }}" />
                            </div>
                                                   

                        </div>
                        

                      
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('organization.save')) }}</button>
                      </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    $('#expires_at').datepicker({
        uiLibrary: 'bootstrap5'
    });
  
</script>
@endsection

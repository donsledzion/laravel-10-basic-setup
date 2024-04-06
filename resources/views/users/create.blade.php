@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('user.form.creation')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" />
                              <label class="form-label" for="name">{{ ucfirst(__('user.form.name')) }}</label>
                                @error('name')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" />
                              <label class="form-label" for="email">{{ ucfirst(__('user.form.email')) }}</label>
                                @error('email')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col">
                                @if(isset($organization))
                                <input id="organization_id" name="organization_id" type="hidden" value="{{ $organization->id}} " />
                                <input id="role" name="role" type="hidden" value="{{ $role }} " />
                                <span><strong>{{ ucfirst(__('user.roles.'.$role)) }}</strong></span></br>
                                
                                @else
                                <select id="role" name="role" class="form-select">
                                    @foreach(\App\Enums\UserRoles::cases() as $role)
                                        <option value="{{ $role->value }}" @if( old('role') == $role->value) selected @endif>{{ ucfirst(__('user.roles.'.$role->value)) }}</option>
                                    @endforeach
                                </select>
                                @endif
                                <label class="form-label" for="role">{{ ucfirst(__('user.role')) }}</label>
                                @error('role')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                      
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('organization.create')) }}</button>
                      </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
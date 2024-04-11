@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('user.form.edit')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.update',[$user]) }}">
                        @csrf
                        @method("PATCH")
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                @if(\Auth::user()->id == $user->id)
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('user.form.name')) }}</label>
                                    @error('name')
                                        <div class="text-danger">{{ __($message) }}</div>
                                    @enderror
                                @else
                                    <label >{{ ucfirst(__('user.card.name')) }}</label></br>
                                    @if(empty($user->name))
                                        <span class="text-danger"><strong>{{ __('user.roles.none')}}</strong></span>  
                                    @else
                                        <span><strong>{{ $user->name}}</strong></span>  
                                    @endif
                                @endif
                            </div>
                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly />
                              <label class="form-label" for="email">{{ ucfirst(__('user.form.email')) }}</label>
                                @error('email')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                        </div>
                        @if(\Auth::user()->role->value == 'admin')
                        <div class="row mb-4">
                            <div class="col">
                                <select id="role" name="role" class="form-select">
                                    @foreach(\App\Enums\UserRoles::cases() as $role)                                    
                                        <option value="{{ $role }}" @if( old('role') == $role ||  $user->role == $role)  selected @endif>{{ ucfirst(__('user.roles.'.$role->value)) }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label" for="role">{{ ucfirst(__('user.role')) }}</label>
                                @error('role')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif
                      
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('user.save_changes')) }}</button>
                      </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
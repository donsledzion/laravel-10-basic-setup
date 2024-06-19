@extends('layouts.app')

@section('head')
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    @vite(['resources/js/toggle-pin-input.js'])
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('scenario.form.edit')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('scenario.update',[$scenario]) }}">
                        @csrf
                        @method("PATCH")
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old("name",$scenario->name) }}" placeholder="{{ __('scenario.placeholder.name') }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('scenario.name')) }}</label>
                                      @error('name')
                                          <div class="text-danger">{{ __($message) }}</div>
                                      @enderror
                                  </div>
                            </div>
                            <div class="row mb-4 mt-4">
                                <div class="col">
                                    <div data-mdb-input-init class="form-outline">
                                      <input type="password" id="pin" name="pin" class="form-control" placeholder="{{ __('scenario.placeholder.pin') }}" value="{{ old('pin',$scenario->pin) }}"/>
                                      <i href="#" class="fa-regular fa-eye-slash toggle-password" style="cursor: pointer;"></i>
                                      <label class="form-label" for="pin">{{ ucfirst(__('scenario.pin')) }}</label>
                                        @error('pin')
                                            <div class="text-danger">{{ __($message) }}</div>
                                        @enderror
                                    </div>
                                  </div>
                            </div>

                          </div>
                          <div class="col">
                            <div data-mdb-input-init class="form-outline">
                              <textarea id="description" rows="5" name="description" class="form-control" placeholder="{{ __('scenario.placeholder.description') }}">{{ old("description",$scenario->description) }}</textarea>
                              <label class="form-label" for="description">{{ ucfirst(__('scenario.description')) }}</label>
                                @error('description')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">

                        </div>


                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('scenario.save')) }}</button>
                      </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

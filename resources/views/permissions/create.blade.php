@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('permission.add-card')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('permission.store') }}">
                        @csrf
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old("name") }}" placeholder="{{ __('permission.form.placeholder.name') }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('scenario.name')) }}</label>
                                      @error('name')
                                          <div class="text-danger">{{ __($message) }}</div>
                                      @enderror
                                  </div>
                            </div>
                            

                        
                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('permission.create')) }}</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('answering-interactions.edit-card')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('answeringInteractionType.update',$interaction) }}">
                        @csrf
                        @method("PUT")
                        <!-- 2 column grid layout with text inputs for organization name and prefix -->
                        <div class="row mb-4">
                          <div class="col">
                            <div class=row>
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old("name", $interaction->name) }}" placeholder="{{ __('answering-interactions.form.placeholder.name') }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('answering-interactions.name')) }}</label>
                                      @error('name')
                                          <div class="text-danger">{{ __($message) }}</div>
                                      @enderror
                                    <input type="text" id="key" name="key" class="form-control" value="{{ old("key", $interaction->key) }}" placeholder="{{ __('answering-interactions.form.placeholder.key') }}" />
                                    <label class="form-label" for="name">{{ ucfirst(__('answering-interactions.key')) }}</label>
                                      @error('key')
                                          <div class="text-danger">{{ __($message) }}</div>
                                      @enderror
                                  </div>
                            </div>



                        <!-- Submit button -->
                        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">{{ ucfirst(__('answering-interactions.update')) }}</button>
                </div>
            </div>
                    </form>
        </div>
    </div>
</div>
@endsection

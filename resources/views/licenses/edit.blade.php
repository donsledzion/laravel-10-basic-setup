@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('license.edit-form-header') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body p-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-8 col-xl-8 text-center">
                                <form name="license" id="license" method="post" action="{{route('license.store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-outline mb-3">
                                        <input name="code" type="text" id="code"
                                               class="form-control form-control-lg"
                                               value="{{$license->code}}" disabled/>
                                        <label class="form-label" for="typeEmail">{{__('license.code')}}</label>
                                    </div>

                                    <div class="form-outline mb-3">
                                        <input name="code" type="text" id="code"
                                               class="form-control form-control-lg"
                                               value="{{$license->device}}" disabled/>
                                        <label class="form-label" for="typeEmail">{{__('license.registered-device')}}</label>
                                    </div>

                                    <div class="form-outline mb-3  col-md-6 col-xl-6">
                                        <input name="expires_at" type="date" id="license_expiration"
                                               class="@error('expires_at') is-invalid @enderror
                                                   form-control form-control-lg"
                                               value="{{$license->expires_at->format('Y-m-d')}}"/>
                                        @error('expires_at')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror

                                        <label class="form-label" for="typeEmail">{{__('license.expiration-date')}}</label>
                                    </div>

                                    <div class="form-outline mb-3  col-md-6 col-xl-6">
                                        <input name="description" type="text" id="license_description"
                                               class="@error('description') is-invalid @enderror
                                                   form-control form-control-lg" value="{{$license->description}}" />
                                        @error('description')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                        <label class="form-label" for="typePassword">{{__('license.description')}}</label>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-info btn-block btn-lg" type="submit">{{__('license.save-changes')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

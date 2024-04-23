@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('auth.verify.title')) }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ ucfirst(__('auth.verify.fresh-email-sent')) }}
                        </div>
                    @endif

                    {{ ucfirst(__('auth.verify.before-proceeding'))}}
                    {{ ucfirst(__('auth.verify.if-didnt-receive-email')) }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.buttons.resent') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

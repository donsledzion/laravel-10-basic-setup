@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('user.users')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                      <a href="{{ route('user.create') }}"> <button class="btn btn-info">{{ ucfirst(__('user.add')) }}</button></a>
                    </p>
                    
                    @foreach($users as $user)
                    {{ $user->name }} - {{ $user->email }} - {{ ucfirst(__('user.roles.'.$user->role)) }} - <a href="{{ route('user.edit',[$user]) }}"><button class="btn btn-success">{{ ucfirst(__('user.edit')) }}</button></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                    
                    
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('user.name') }}</th>
                          <th scope="col">{{ __('user.email') }}</th>
                          <th scope="col">{{ __('user.role') }}</th>
                          <th scope="col">{{ __('user.options') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                        <tr>
                          <th scope="row">1</th>
                          <td>
                            @if(empty($user->name))
                                <span class="text-danger"><strong>{{ __('user.roles.none')}}</strong></span>  
                            @else
                                {{ $user->name}}
                            @endif</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ ucfirst(__('user.roles.'.$user->role->value)) }}</td>
                          <td>
                            <a href="{{ route('user.edit',[$user]) }}"><button class="btn btn-warning">{{ ucfirst(__('user.edit')) }}</button></a>
                            <a href="{{ route('user.show',[$user]) }}"><button class="btn btn-info">{{ ucfirst(__('user.show')) }}</button></a>
                          </td>
                        </tr>                     
                        @endforeach
                        
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
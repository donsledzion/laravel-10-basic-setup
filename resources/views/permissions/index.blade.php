@extends('layouts.app')
@section('head')
@vite(['resources/js/permissions-toggle.js'])
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('permission.index')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                      <a href="{{ route('permission.create') }}"> <button class="btn btn-info">{{ ucfirst(__('permission.add')) }}</button></a>
                    </p>


                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th >{{ __('permission.name') }}</th>
                          @foreach(\App\Models\Role::all() as $role)
                            <th>{{ __('role.'.$role->name) }}</th>
                          @endforeach
                          <th >{{ __('permission.edit') }}</th>
                          <th >{{ __('permission.remove') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($permissions as $permission)
                        <tr data-permission-id="{{ $permission->id }}">
                            <td>{{ $permission->name}}</td>
                                @foreach(\App\Models\Role::all() as $role)
                                    <td >
                                        <input class="form-check-input role-toggle" data-role-id="{{ $role->id }}" type="checkbox" value="" id="flexCheckDefault" @if($permission->roles->contains($role)) checked="checked" @endif>
                                    </td>
                                @endforeach
                            <td>
                                <a href="{{ route('permission.edit',[$permission]) }}"><button class="btn btn-warning">E</button></a>
                            </td>
                            <td>
                                <a href="{{ route('permission.destroy',[$permission]) }}"><button class="btn btn-danger">D</button></a>
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

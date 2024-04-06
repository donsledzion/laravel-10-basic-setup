@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('organization.organizations')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('organization.create') }}"><button class="btn btn-info">{{ ucfirst(__('organization.add')) }}</button></a>

                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ ucfirst(__('organization.name')) }}</th>
                            <th scope="col">{{ ucfirst(__('organization.prefix')) }}</th>
                            <th scope="col">{{ ucfirst(__('organization.members.members')) }}</th>
                            <th scope="col">{{ ucfirst(__('organization.scenarios.scenarios')) }}</th>
                            <th scope="col">{{ ucfirst(__('organization.options')) }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($organizations as $organization)
                          <tr>
                            <th scope="row">1</th>
                            <td>{{ $organization->name }}</td>
                            <td>{{ $organization->prefix }}</td>
                            <td>{{ $organization->users()->count() }}</td>
                            <td><!--  -->n/a</td>
                            <td>
                              <a href="{{ route('organization.edit',[$organization]) }}"><button class="btn btn-warning">{{ ucfirst(__('organization.edit')) }}</button></a>
                              <a href="{{ route('organization.show',[$organization]) }}"><button class="btn btn-info">{{ ucfirst(__('organization.show')) }}</button></a>
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
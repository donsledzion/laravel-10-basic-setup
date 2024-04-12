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
                      <a href="{{ route('scenario.create') }}"> <button class="btn btn-info">{{ ucfirst(__('scenario.add')) }}</button></a>
                    </p>
                    
                    
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('scenario.name') }}</th>
                          <th scope="col">{{ __('scenario.pin') }}</th>
                          <th scope="col">{{ __('scenario.quizzes') }}</th>
                          <th scope="col">{{ __('scenario.organizations') }}</th>
                          <th scope="col">{{ __('scenario.options') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($scenarios as $scenario)
                        <tr>
                          <th scope="row">1</th>
                          <td>                            
                            {{ $scenario->name}}
                            <td>
                                @if(empty($scenario->pin))
                                {{ ucfirst(__('scenario.none')) }}
                                @else
                                {{ ucfirst(__('scenario.yes')) }}
                                @endif
                            </td>
                          <td>{{ $scenario->quizzes->count() }}</td>
                          <td>{{ $scenario->organizations->count() }}</td>
                          <td>
                            <a href="{{ route('scenario.edit',[$scenario]) }}"><button class="btn btn-warning">{{ ucfirst(__('scenario.edit')) }}</button></a>
                            <a href="{{ route('scenario.show',[$scenario]) }}"><button class="btn btn-info">{{ ucfirst(__('scenario.show')) }}</button></a>
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
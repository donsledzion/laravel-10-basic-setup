@extends('layouts.app')
@section('head')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(__('answering-interactions.index')) }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                      <a href="{{ route('answeringInteractionType.create') }}"> <button class="btn btn-info">{{ ucfirst(__('answering-interactions.add')) }}</button></a>
                    </p>


                    <table class="table table-striped">
                      <thead>
                        <tr>
                            <th >{{ __('answering-interactions.name') }}</th>
                            <th >{{ __('answering-interactions.key') }}</th>
                            <th >{{ __('answering-interactions.edit') }}</th>
                            <th >{{ __('answering-interactions.remove') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($interactions as $interaction)
                        <tr data-interaction-id="{{ $interaction->id }}">
                            <td>{{ $interaction->name}}</td>
                            <td>{{ $interaction->key}}</td>
                            <td>
                                <a href="{{ route('answeringInteractionType.edit',$interaction) }}"><button class="btn btn-warning">E</button></a>
                            </td>
                            <td>
                                <button class="btn btn-danger delete-interaction" data-id="{{ $interaction->id }}"><i class="fa-solid fa-trash-can"></i></button>
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

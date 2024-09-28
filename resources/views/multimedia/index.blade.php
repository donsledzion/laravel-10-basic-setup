@extends('layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ucfirst(__('multimedia.index')) }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>
                            <a href="{{ route('audioBackground.create') }}"> <button class="btn btn-info">{{ ucfirst(__('multimedia.audio.add')) }}</button></a>
                            <a href="{{ route('skyboxBackground.create') }}"> <button class="btn btn-info">{{ ucfirst(__('multimedia.skybox.add')) }}</button></a>
                        </p>


                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th >{{ __('multimedia.audio.name') }}</th>
                                <th >{{ __('multimedia.audio.preview') }}</th>
                                <th >{{ __('multimedia.audio.edit') }}</th>
                                <th >{{ __('multimedia.audio.remove') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audios as $audio)
                                <tr data-interaction-id="{{ $audio->id }}">
                                    <td>{{ $audio->name}}</td>
                                    <td>
                                        <audio id="audio" controls="controls">
                                            <source id="audioSource" src="{{$audio->media->getMediaPath()}}">
                                        </audio>
                                    </td>
                                    <td>
                                        <a href="{{ route('audioBackground.edit',$audio) }}"><button class="btn btn-warning">E</button></a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger delete-interaction" data-id="{{ $audio->id }}"><i class="fa-solid fa-trash-can"></i></button>
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

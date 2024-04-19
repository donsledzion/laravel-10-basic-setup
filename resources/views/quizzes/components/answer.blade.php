<div class="row">
    <div class="col">
        @if ($answer->answerFileMediaType() == \App\Enums\MediaTypes::PICTURE)
        <div class="col my-2 p-4 @if($answer->is_correct) bg-success @else bg-danger @endif rounded">
        <img src="{{ asset('organizations'.'/'.$answer->quiz->scenario->organization->id.'/pictures/'.$answer->content) }}" class="img-fluid " >
        <div class="col text-center">
            <a href="{{ route('answer.edit',[$answer]) }}"><button class="btn btn-warning py-2 my-1 mt-1 fa-regular fa-pen-to-square"></button></a>
            <button class="btn btn-danger py-2 my-1 fa-regular fa-trash-can delete-answer" data-id="{{ $answer->id }}"></button>
            </div>
        </div>
        @elseif($answer->answerFileMediaType() == \App\Enums\MediaTypes::AUDIO)
        <div class="row">
            <div class="col-10">
                <audio controls class="py-2 my-2 @if($answer->is_correct) bg-success @else bg-danger @endif">
                    <source src="{{ asset('organizations'.'/'.$answer->quiz->scenario->organization->id.'/audios/'.$answer->content) }}" type="audio/mp3">
                </audio> 
            </div>
            <div class="col-2">
                <a href="{{ route('answer.edit',[$answer]) }}"><button class="btn btn-warning py-2 my-1 mt-1 fa-regular fa-pen-to-square"></button></a>
                <button class="btn btn-danger py-2 my-1 fa-regular fa-trash-can delete-answer" data-id="{{ $answer->id }}"></button>
            </div>
    </div>
        @else
        <div class="row">
            <div class="col-10 @if($answer->is_correct) bg-success @else bg-danger @endif rounded py-2 text-white fw-bold my-1">{{ $answer->content }}</div>     
            <div class="col-2">
                <a href="{{ route('answer.edit',[$answer]) }}"><button class="btn btn-warning py-2 my-1 mt-1 fa-regular fa-pen-to-square"></button></a>
                <button class="btn btn-danger py-2 my-1 fa-regular fa-trash-can delete-answer" data-id="{{ $answer->id }}"></button>
            </div>
        <div>
        @endif
    </div>
</div>
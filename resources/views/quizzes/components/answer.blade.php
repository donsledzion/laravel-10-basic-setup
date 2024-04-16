<div class="row">
@if ($answer->answerFileMediaType() == \App\Enums\MediaTypes::PICTURE)
<img src="{{ asset('organizations'.'/'.$answer->quiz->scenario->organization->id.'/pictures/'.$answer->content) }}" class="img-fluid" >
@elseif($answer->answerFileMediaType() == \App\Enums\MediaTypes::AUDIO)
<audio controls class="py-2 my-2 @if($answer->is_correct) bg-success @else bg-danger @endif">
    <source  src="{{ asset('organizations'.'/'.$answer->quiz->scenario->organization->id.'/audios/'.$answer->content) }}" type="audio/mp3">
</audio> 
@else
    <button class="btn @if($answer->is_correct) btn-success @else btn-danger @endif my-1">{{ $answer->content }}</button>     
@endif

</div>
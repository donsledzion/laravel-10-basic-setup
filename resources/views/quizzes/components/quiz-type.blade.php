@if($quiz->type == \App\Enums\QuizTypes::PUT_IN_ORDER)
        <i class="fa-solid fa-arrow-down-1-9"></i>
@else
    @if($quiz->questionFileMediaType() == \App\Enums\MediaTypes::AUDIO)
        <i class="fa-solid fa-music"></i>
    @elseif($quiz->questionFileMediaType() == \App\Enums\MediaTypes::PICTURE)
        <i class="fa-regular fa-image"></i>
    @else
        <i class="fa-solid fa-font"></i>
    @endif
    <i class="fa-solid fa-arrow-right-long"></i>
    @if($quiz->answerFileMediaType() == \App\Enums\MediaTypes::PICTURE)
        <i class="fa-regular fa-image"></i>
    @elseif(($quiz->answerFileMediaType() == \App\Enums\MediaTypes::AUDIO))
        <i class="fa-solid fa-music"></i>
    @else
        <i class="fa-solid fa-font"></i>
    @endif
@endif

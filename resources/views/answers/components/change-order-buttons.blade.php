<button class="btn btn-primary move-up" @if($answer->isFirst()) disabled @endif data-id="{{ $answer->id }}"><i class="fa-solid fa-sort-up"></i></button>
<button class="btn btn-secondary move-down" @if($answer->isLast()) disabled @endif data-id="{{ $answer->id }}"><i class="fa-solid fa-sort-down"></i></button>

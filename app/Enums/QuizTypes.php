<?php

namespace App\Enums;

enum QuizTypes: string {

    case TEXT_2_TEXT = 'text2text';
    case TEXT_2_PICTURE = 'text2picture';
    case TEXT_2_AUDIO = 'text2audio';
    case AUDIO_2_TEXT = 'audio2text';
    case AUDIO_2_AUDIO = 'audio2audio';
    case PICTURE_2_TEXT = 'picture2text';
    case PUT_IN_ORDER = 'put-in-order';
}
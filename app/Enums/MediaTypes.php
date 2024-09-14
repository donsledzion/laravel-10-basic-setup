<?php
namespace App\Enums;

enum MediaTypes: string {

    case AUDIO = 'audio';
    case PICTURE = 'picture';
    case VIDEO = 'video';

    public static function toArray(): array
    {
        return array_column(MediaTypes::cases(), 'value');
    }
}

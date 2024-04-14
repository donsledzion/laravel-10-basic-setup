<?php

namespace App\Http\Requests;

use App\Enums\QuizTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => [new Enum(QuizTypes::class)],
            'question_text' => 'required|string|min:4|max:512',
            'question_picture' => 
                'required_if:type,picture2text|exclude_if:type,text2text,text2picture,text2audio,audio2text,audio2audio,put-in-order|file|mimes:png,jpg,bmp|max:10240',
            'question_audio' => 
                'required_if:type,audio2text,audio2audio|exclude_if:type,text2text,text2picture,text2audio,picture2text,put-in-order|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
        ];
    }
}

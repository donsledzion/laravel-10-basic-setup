<?php

namespace App\Http\Requests;

use App\Enums\MediaTypes;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\QuizTypes;
use Illuminate\Validation\Rules\Enum;

class UpdateQuizRequest extends FormRequest
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
        $rules = [
            //'type' => [new Enum(QuizTypes::class)],
            'question_text' => 'string|min:4|max:512',
        ];
        if($this->quiz->questionFileMediaType() == MediaTypes::AUDIO){
            $rules['question_picture'] = 'file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav';
        } else if($this->quiz->questionFileMediaType() == MediaTypes::PICTURE){
            $rules['question_picture'] = 'file|mimes:png,jpg,bmp|max:10240';
        }            
        return $rules;
    }
}

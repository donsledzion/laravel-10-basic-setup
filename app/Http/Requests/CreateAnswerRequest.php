<?php

namespace App\Http\Requests;

use App\Enums\MediaTypes;
use App\Enums\QuizTypes;
use Illuminate\Foundation\Http\FormRequest;

class CreateAnswerRequest extends FormRequest
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
            'content' => 'required|string',
            //'is_correct' => 'boolean',
            'order' => 'numeric',
        ];

        if($this->quiz->type != QuizTypes::PUT_IN_ORDER){
            $rules['is_correct'] = 'boolean';
        }

        if($this->quiz->answerFileMediaType() == MediaTypes::AUDIO){
            $rules['content'] = 'required|file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav';
        } else if($this->quiz->answerFileMediaType() == MediaTypes::PICTURE){
            $rules['content'] = 'required|file|mimes:png,jpg,bmp|max:10240';
        }


        return $rules;
    }
}

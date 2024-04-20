<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\MediaTypes;
use App\Enums\QuizTypes;

class UpdateAnswerRequest extends FormRequest
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
            'content' => 'nullable|string',
            //'is_correct' => 'boolean',
            'order' => 'numeric',
        ];
        
        if($this->quiz->type != QuizTypes::PUT_IN_ORDER){
            $rules['is_correct'] = 'boolean';
        }

        if($this->answer->quiz->answerFileMediaType() == MediaTypes::AUDIO){
            $rules['content'] = 'nullable|file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav';
        } else if($this->answer->quiz->answerFileMediaType() == MediaTypes::PICTURE){
            $rules['content'] = 'nullable|file|mimes:png,jpg,bmp|max:10240';
        }

        return $rules;
    }
}

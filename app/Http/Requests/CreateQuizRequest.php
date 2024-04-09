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
            'question_picture' => 'string',
            'question_audio' => 'string'
        ];
    }
}

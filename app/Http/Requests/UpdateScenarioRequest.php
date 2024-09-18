<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScenarioRequest extends FormRequest
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
            'name' => 'string|min:3|max:128|unique:organizations,name',
            'description' => 'string|min:5|max:1024',
            'pin' => 'nullable|numeric|digits:4',
            'color_question_text' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_answer_text' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_question_background' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_answer_background' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_floor' => ['regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'logo' => 'nullable|file|mimes:png|max:5120'
            ];
    }
}

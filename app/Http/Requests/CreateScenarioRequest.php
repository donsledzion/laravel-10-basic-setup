<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScenarioRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:128',
            'description' => 'string|min:5|max:1024',
            'pin' => 'nullable|string|digits:4',
            'color_question_text' => ['required','regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_answer_text' => ['required','regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_question_background' => ['required','regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_answer_background' => ['required','regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'color_floor' => ['required','regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'logo' => 'nullable|file|mimes:png|max:5120',
            'interaction_id' => 'numeric|exists:answering_interaction_types,id'
            ];
    }
}

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|min:3|max:256|unique:organizations,name',
            'prefix' => 'string|min:3|max:6|unique:organizations,prefix',
            'expires_at' => 'date',
            'headset_login' => 'string|min:5|max:15|unique:organizations,headset_login',
            'headset_pin' => 'numeric|digits:4',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120'
            ];
    }
}

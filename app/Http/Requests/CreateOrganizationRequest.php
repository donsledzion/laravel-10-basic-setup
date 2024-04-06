<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizationRequest extends FormRequest
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
        'name' => 'required|string|min:3|max:256|unique:organizations,name',
        'prefix' => 'required|string|min:5|max:10|unique:organizations,prefix',
        'expires_at' => 'required|date',
        'headset_login' => 'required|string|min:5|max:15|unique:organizations,headset_login',
        'headset_pin' => 'required|numeric|digits:4|',
        'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120'
        ];
    }
}

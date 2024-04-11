<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
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
            'name' => 'string|min:3|max:256',
            'prefix' => 'string|min:5|max:10',
            'expires_at' => 'date',
            'headset_login' => 'string|min:5|max:15',
            'headset_pin' => 'numeric|digits:4',
            'logo' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:5120'
            ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Models\Organization;

class CreateOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isAllowed('create_organization');
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
        'logo' => 'nullable|file|mimes:png|max:5120'
        ];
    }
}

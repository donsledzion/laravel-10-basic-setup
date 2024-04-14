<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Models\Organization;

class UpdateOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $organization = Organization::find($this->organization->id);
        return \Auth::user()->isAllowed('edit_organization',$organization);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $organization = Organization::find($this->organization->id);
        $rules = [
            'name' => 'string|min:3|max:256',
            'prefix' => 'string|min:5|max:10',
            'headset_login' => 'string|min:5|max:15',
            'headset_pin' => 'numeric|digits:4',
            'logo' => 'nullable|file|mimes:png|max:5120'
            ];

            if(\Auth::user()->isAllowed('set_organization_expiration_date',$organization)){
                $rules['expires_at'] = 'date';
            }

        return $rules;
    }
}

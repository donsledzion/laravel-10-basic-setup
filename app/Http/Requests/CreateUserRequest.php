<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRoles;
use App\Models\Organization;
use App\Models\Role;
use Illuminate\Validation\Rules\Enum;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        
        //dd($this->organization_id);
        $role = Role::findOrFail($this->organization_role);
        $organization = Organization::findOrFail($this->organization_id);
        //dd($role->name);
        if($role->name == 'global-admin')
            return \Auth::user()->isAllowed('create_admin');
        return \Auth::user()->isAllowed('create_organization_'.$role->name, $organization);        
        //check if \Auth::user() is Allowed to register new Admin / OrganizationAdmin / Manager / Trainer
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Ensure that \Auth::user() is allowed to set new user's name should be allowed only to self change.
        
        return [
            'email' => 'required|email',
            'role' => [new Enum(UserRoles::class)]
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Models\Role;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user->id == \Auth::user()->id)
            return true;
        $role = Role::findOrFail($this->organization_role);
        if($role->name == 'global-admin')
            return \Auth::user()->isAllowed('edit_admin');
        return \Auth::user()->isAllowed('create_organization_'.$role->name);        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        if(\Auth::user()->isUser()){
            $rules['name'] = 'string|min:5|max:40';
        }

        if(\Auth::user()->isAdmin()){
            $rules['role'] = [new Enum(UserRoles::class)];
        }

        return $rules;
    }
}

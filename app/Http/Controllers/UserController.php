<?php

namespace App\Http\Controllers;

use App\Enums\OrganizationRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Organization;
use App\Enums\UserRoles;
use App\Models\Role;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function index()
    {
        $role = \Auth::user()->role;
        $users = null;
        //dd($role);
        switch($role){
            case UserRoles::ADMIN:
                $users = User::all();
                break;
            case UserRoles::USER:
                $user = \Auth::user();
                $users = new Collection();
                foreach($user->organizations as $organization){
                    foreach($organization->users as $member){
                        $users->push($member);
                    }
                }
                break;
            default:
                return redirect('/home');
                break;
        }

        return view('users.index',[
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        return view('users.show',[
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function createManager(Organization $organization)
    {
        return view('users.create',[
            'organization' => $organization,
            'role' => Role::firstWhere('name','manager')
        ]);
    }

    public function createTrainer(Organization $organization)
    {
        return view('users.create',[
            'organization' => $organization,
            'role' => Role::firstWhere('name','trainer')
        ]);
    }

    public function createAdmin(Organization $organization)
    {
        return view('users.create',[
            'organization' => $organization,
            'role' => Role::firstWhere('name','admin')
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        try{
            $user = User::where('email',$request->email)->first();
            if($user == null)
                $user = User::create($request->validated());
            if(isset($request->organization_id)){
                $organization = Organization::find($request->organization_id);
                $organizationRole = Role::find($request->organization_role);
                if($organization == null || $organizationRole == null)
                    return redirect(route('home'));

                if(!\Auth::user()->isAllowed('create_organization_'.$organizationRole->name,$organization)){
                    error_log('create_organization_'.$organizationRole->name);
                    return redirect(route('home'));
                }

                $user->organizations()->attach($request->organization_id,[
                    'role_id' => $request->organization_role
                ]);
            }
            return redirect(route('user.show',[$user]));
        } catch(\Exception $e){
            $msg = "An error occurred while trying to store user. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::error('$msg');
        }
    }

    public function edit(User $user)
    {
        return view('users.edit',[
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try{            
            $user->update($request->validated());
            return redirect(route('user.show',[$user]));
        }catch(\Exception $e){
            $msg = "An error occurred while trying to update user. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }
    }

    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect(route('users.index'));
        } catch(\Exception $e){
            $msg = "An error occured while trying to delete user. ".$e->getMessage();
            Log::error($msg);
        }

    }
}

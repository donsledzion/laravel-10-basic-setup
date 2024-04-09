<?php

namespace App\Http\Controllers;

use App\Enums\OrganizationRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Organization;
use App\Enums\UserRoles;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function index()
    {
        $role = \Auth::user()->role;
        $users = null;
        switch($role){
            case UserRoles::ADMIN->value:
                $users = User::all();
                break;
            case UserRoles::USER->value:
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
            'role' => OrganizationRoles::MANAGER->value
        ]);
    }

    public function createTrainer(Organization $organization)
    {
        return view('users.create',[
            'organization' => $organization,
            'role' => OrganizationRoles::TRAINER->value
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        try{
            $user = User::where('email',$request->email)->first();
            if($user == null)
                $user = User::create($request->validated());
            if(isset($request->organization_id)){
                $user->organizations()->attach($request->organization_id,[
                    'role' => $request->organization_role
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

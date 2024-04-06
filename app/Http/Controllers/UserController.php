<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Organization;
use App\Enums\UserRoles;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $role = \Auth::user()->role;
        $users;
        switch($role){
            case UserRoles::ADMIN->value:
                $users = User::all();
                break;
            case UserRoles::MANAGER->value:
                $user = \Auth::user();
                $users = User::whereHas('organizations',function($query) use ($user) {
                    $query->whereIn('id', $user );
                })->get();
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
            'role' => UserRoles::MANAGER->value
        ]);
    }

    public function createTrainer(Organization $organization)
    {
        return view('users.create',[
            'organization' => $organization,
            'role' => UserRoles::TRAINER->value
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        try{
            $user = User::create($request->validated());
            if(isset($request->organization_id)){
                $user->organizations()->attach($request->organization_id);
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

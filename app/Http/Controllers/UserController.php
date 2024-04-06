<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index',[
            'users' => User::all()
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

    public function store(CreateUserRequest $request)
    {
        try{
            $user = User::create($request->validated());
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

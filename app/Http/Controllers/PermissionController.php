<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use \App\Models\Role;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        $permissions = Permission::all();
        return view('permissions.index',[
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request):RedirectResponse
    {
        Permission::create($request->validated());
        return redirect(route('permission.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('permissions.show',[
            'permission' => $permission
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission):ViewView
    {
        return view('permissions.edit',[
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission):RedirectResponse
    {
        $permission->update($request->validated());
        return redirect(route('permission.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission):JsonResponse
    {
        try{
            $permission->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'deleted'
            ])->setStatusCode(200);
        }catch(\Exception $e){
            $msg = "Failed to delete permission! ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return response()->json([
                'status' => 'error',
                'message' => $msg
            ])->setStatusCode(206);
        }
    }

    public function toggle(Permission $permission, Role $role)
    {
        error_log("About to toggle permission ".$permission->name." for role ".$role->name."!");
        try{
            if($permission->roles->contains($role)){
                $permission->roles()->detach($role);
                $active = false;
            } else {
                $permission->roles()->attach($role);
                $active = true;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'permission.update.success',
                'active' => $active
            ])->setStatusCode(200);
        } catch (\Exception $e){
            $msg = "Failed to toggle permission for user role. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return response()->json([
                'status' => 'failed',
                'message' => $msg
            ])->setStatusCode(418);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Organization;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = \Auth::user()->organizations;
        if(\Auth::user()->role == UserRoles::ADMIN)
            $organizations = Organization::all();
        return view('organizations.index', [
            'organizations' => $organizations
        ]);
    }

    public function show(Organization $organization)
    {
        return view('organizations.show',[
            'organization' => $organization
        ]);
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(CreateOrganizationRequest $request)
    {
        //dd($request);
        try{            
            $organization = Organization::create($request->validated());
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $fileName = $file->getClientOriginalName();
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $hashName = hash('sha256',$fileName).'.'.$ext;
                $file->storeAs('multimedia/'.$organization->id.'/pictures/', $hashName);
                $organization->logo = $hashName;
                $organization->save();
                //dd($filePath);
            }
            return redirect(route('organization.show',[$organization]))->with('success','Dodano organizację!');
            
        } catch(\Exception $e) {
            $msg = "An exception occured while trying to create organization entry. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::Error($msg);
        }
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit',[
            'organization' => $organization
        ]);
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $old_logo = $organization->logo;
        $organization->update($request->validated());
        if($request->hasFile('logo')){            
            $file = $request->file('logo');
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $file->storeAs('multimedia/'.$organization->id.'/pictures/', $hashName);
            $organization->logo = $hashName;
            $organization->save();
            $organization->removeLogoFile($old_logo);
        }
        return redirect(route('organization.show',[
            $organization
        ]));
        return view('organizations.show',[
            'organization' => $organization
        ]);
    }

    public function destroy(Organization $organization)
    {
        try{
            $organization->removeLogoFile();
            $organization->delete();            
        } catch(\Exception $e){
            $msg = "An error occured while trying to remove organization. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);            
        } finally {
            return redirect(route('organization.index')); 
        }
        
    }
}

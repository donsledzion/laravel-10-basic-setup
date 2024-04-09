<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;

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
        try{            
            return redirect(route('organization.show',[
                Organization::create($request->validated())
            ]));
            
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
        $organization->update($request->validated());
        return redirect(route('organization.show',[
            $organization
        ]));
        return view('organizations.show',[
            'organization' => $organization
        ]);
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect(route('organization.index'));        
    }
}

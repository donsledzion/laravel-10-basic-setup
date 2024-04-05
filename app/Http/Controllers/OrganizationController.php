<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;

class OrganizationController extends Controller
{
    public function index()
    {
        return view('organizations.index', [
            'organizations' => Organization::all()
        ]);
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(CreateOrganizationRequest $request)
    {
        try{
            
            return view('organization.show',[
                'organization' => Organization::create($request->validated())
            ]);
        } catch(\Exception $e) {
            $msg = "An exception occured while trying to create organization entry. Exception message: ".$e->getMessage();
            Log::Error("An exception occured while trying to create organization entry");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\CreateOrganizationLogoRequest;
use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\MediaFile;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == UserRoles::ADMIN)
            $organizations = Organization::all();
        else
            $organizations = Auth::user()->organizations;

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
            $organization = Organization::create($request->validated());
            if($request->hasFile('logo')){
                $attributes = $request
                    ->merge([
                        'file' => $request->logo,
                        'organization' => $organization->id
                    ])
                    ->validate([
                        'file' => 'nullable|file|mimes:png|max:5120',
                        'organization' => 'required',
                        Rule::exists('organizations','id')
                    ]);
                $logo = MediaFile::create($attributes);
                $organization->logo = $logo->id;
                $organization->save();
            }
            return redirect(route('organization.show',[$organization]))->with('success','Dodano organizację!');

        } catch(\Exception $e) {
            $msg = "An exception occurred while trying to create organization entry. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::Error($msg);
            $organization->delete();
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
        $organization->update(Arr::except($request->validated(),'logo'));
        if($request->hasFile('logo')){
            $attributes = $request
                ->merge([
                    'file' => $request->logo,
                    'organization' => $organization->id
                ])
                ->validate([
                    'file' => 'nullable|file|mimes:png|max:5120',
                    'organization' => 'required',
                    Rule::exists('organizations','id')
                ]);
            $logo = MediaFile::create($attributes);
            $organization->logo = $logo->id;
            $organization->save();
        }
        //TODO -> handle disposing of old logo

        return redirect(route('organization.show',[
            $organization
        ]));
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

    public function removeMember(Organization $organization, User $user)
    {
        try{
            if($user->organizationRole($organization) == null){
                return response()->json([
                    'status' => 'error',
                    'title' => __('organization.message.remove-member.fail.title'),
                    'message' => __('organization.message.remove-member.fail.non-organization-member')
                ])->setStatusCode(203);
            }
            if($organization->admin() == null){
                return response()->json([
                    'status' => 'error',
                    'title' => __('organization.message.remove-member.fail.title'),
                    'message' => __('organization.message.remove-member.fail.no-admin')
                ])->setStatusCode(203);
            }
            if($organization->admin()->id == $user->id){
                error_log("About to remove organization admin. Am I allowed?");
                if(!\Auth::user()->isAllowed('remove_organization_admin',$organization)){
                    return response()->json([
                        'status' => 'error',
                        'title' => __('organization.message.remove-member.fail.title'),
                        'message' => __('organization.message.remove-member.fail.no-permission')
                    ])->setStatusCode(206);
                }
            }
            if($user->organizationRole($organization)->name == 'manager'){
                if(!\Auth::user()->isAllowed('remove_manager',$organization)){
                    return response()->json([
                        'status' => 'error',
                        'title' => __('organization.message.remove-member.fail.title'),
                        'message' => __('organization.message.remove-member.fail.no-permission')
                    ])->setStatusCode(206);
                }
            }
            if($user->organizationRole($organization)->name == 'trainer'){
                if(!\Auth::user()->isAllowed('remove_trainer',$organization)){
                    return response()->json([
                        'status' => 'error',
                        'title' => __('organization.message.remove-member.fail.title'),
                        'message' => __('organization.message.remove-member.fail.no-permission')
                    ])->setStatusCode(206);
                }
            }
            $role_name = $user->organizationRole($organization)->name;
            $organization->removeMember($user);
            return response()->json([
                'status' => 'success',
                'title' => __('organization.message.remove-member.success.title'),
                'message' => __('organization.message.remove-member.success.'.$role_name)
            ])->setStatusCode(200);
        } catch (\Exception $e){
            $msg = 'Failed to remove organization member. '.$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return response()->json([
                'status' => 'error',
                'title' => __('organization.message.remove-member.fail.title'),
                'message' => $msg
            ])->setStatusCode(500);
        }

    }
}

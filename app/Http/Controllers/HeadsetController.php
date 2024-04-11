<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class HeadsetController extends Controller
{
    public function login(Request $request)
    {
        try{
            $organization = Organization::where('headset_login',$request->login)
                                        ->where('headset_pin',$request->pin)
                                        ->first();
            if($organization != null){
                $token = $organization->tokens()->create([
                    'token' => Str::random(32)
                ]);
                $token->organization = $organization;
                $token->scenarios = $organization->scenarios();
                if($organization->expires_at < Carbon::now()){
                    return response()->json(
                        $token,
                    )->setStatusCode(206);
                }
                return response()->json(
                        $token
                )->setStatusCode(200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Could not find organization matching given criteria. Check headset login and password and try again.'
                    ])->setStatusCode(401);
            }

        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Unhandled exception occurred. '.$e->getMessage()
                ])->setStatusCode(500);
        }

        error_log($request->login);
        error_log($request->pin);
        error_log($request->device);
        
    }
}

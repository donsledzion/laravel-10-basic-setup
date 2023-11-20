<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLicenseRequest;
use App\Models\License;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $licenses = License::all();
        return view('licenses.index',
            [
                'licenses' => $licenses
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('licenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseRequest  $request

     */
    public function store(StoreLicenseRequest $request)
    {
        License::create($request->validated());
        $licenses = License::all();
        return view('licenses.index',
            [
                'licenses' => $licenses
            ]);
    }

    /**
     * Display the specified resource.
     *

     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $license)
    {
        error_log('Looking for license');
        $license = License::where('code', $license)->first();
        return view('licenses.edit',[
           'license' => $license
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $license)
    {
        error_log("LicenseController@edit");
        $lic = License::where('code',$license)->first();
        return view('licenses.edit',[
            'license' => $lic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     //* @param  \Illuminate\Http\Request  $request
     //* @param  \App\Models\License  $license
     //* @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $license)
    {
        Log::error("License code: ".$license);
        License::firstWhere('code',$license)->update($request->all());
        return view('licenses.index',[
            'licenses' => License::all()
        ]);
        /*Log::error("Request code: ".$request->code);
        Log::error("Request expiration: ".$request->expires_at);
        Log::error("Description: ".$request->description);*/
        /*LIcense::updateOrCreate([
            'code'
        ],[]);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $license)
    {
        error_log("Trying to destroy license with ID: ".$license);
    }

    /**
     * Turns on given license
     *
     * @param  string  $license
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function turn_on(string $license)
    {
        error_log("Trying to turn on license with ID: ".$license);
        error_log("Trying to turn off license with ID: ".$license);
        $license = License::find($license);
        $license->active = 1;
        $license->save();
        $licenses = License::all();
        return view('licenses.index',
            [
                'licenses' => $licenses
            ]);
    }
    /**
     * Turns off given license
     *
     * @param  string  $license
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function turn_off(string $license)
    {
        error_log("Trying to turn off license with ID: ".$license);
        $license = License::find($license);
        $license->active = 0;
        $license->save();
        $licenses = License::all();
        return view('licenses.index',
            [
                'licenses' => $licenses
            ]);
    }

    public function activate(Request $request)
    {
        Log::debug("Trying to activate license with key ".$request->key. " for device no: ".$request->device);
        $license = License::find($request->key);
        if($license == null)
        {
            Log::debug("License no ".$request->key." not found");
            return response()->json([
                'message' => 'license.not-found',
                'code' => 204
            ])->setStatusCode(206);
        }
        else if($license->device != null)
        {
            if(Carbon::now()->startOfDay()->gte($license->expires_at))
            {
                Log::debug("License no ".$request->key." has already expired");
                return response()->json([
                    'message' => 'license-expired',
                    'code' => 206
                ])->setStatusCode(206);
            }
            Log::debug("License no ".$request->key." is already activated");
            return response()->json([
                'message' => 'license.already-activated',
                'code' => 206
            ])->setStatusCode(206);
        }
        else
        {
            Log::debug("License no ".$request->key." has been successfully activated");
            $license->device = $request->device;
            $license->active = 1;
            $license->save();
            return response()->json([
                'message' => 'license-activated',
                'code' => 202
            ])->setStatusCode(202);
        }

    }

    public function check(string $device)
    {
        Log::debug("Trying to hit get request for LicenseController@count method");
        $licenses = License::where('device',$device)->get();
        if($licenses->count() > 0)
        {
            $license = $licenses->where('expires_at','>=',Carbon::now())->where('active',true)->first();
            if($license == null)
            {
                Log::debug("Any license for ".$device." has not  already expired");
                return response()->json([
                    'message' => 'license.expired',
                    'expiration' => $license->expires_at,
                    'code' => 202
                ])->setStatusCode(206);
            }
            Log::debug("Found license with ". $license->code);
            return response()->json([
                'message' => 'license.valid',
                'expiration' => $license->expires_at,
                'code' => 200
            ])->setStatusCode(200);
        }
        else
        {
            Log::debug("Any license for ".$device." has not already expired");
            return response()->json([
                'message' => 'license.unknown-device',
                'code' => 203
            ])->setStatusCode(206);
        }
    }
}

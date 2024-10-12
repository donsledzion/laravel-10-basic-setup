<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSkyboxBackgroundRequest;
use App\Models\MediaFile;
use App\Models\SkyboxBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SkyboxBackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('multimedia.skybox.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSkyboxBackgroundRequest $request)
    {
        try{
            //dd($request);
            $skybox = SkyboxBackground::create($request->validated());
            if($request->hasFile('texture')){
                $attributes = $request
                    ->merge([
                        'file' => $request->texture,
                        'skybox' => $skybox->id
                    ])
                    ->validate([
                        'file' => 'required|file|mimes:jpg',
                        'skybox' => 'required',
                        Rule::exists('media_files','id')
                    ]);
                $mediaFile = MediaFile::create($attributes);
                $skybox->texture_id = $mediaFile->id;
            }
            if($request->hasFile('thumbnail')){
                $attributes = $request
                    ->merge([
                        'file' => $request->thumbnail,
                        'skybox' => $skybox->id
                    ])
                    ->validate([
                        'file' => 'required|file|mimes:jpg,png|max:51200',
                        'skybox' => 'required',
                        Rule::exists('media_files','id')
                    ]);
                $mediaFile = MediaFile::create($attributes);
                $skybox->thumbnail_id = $mediaFile->id;
            }

            $skybox->save();
            return redirect(route('multimedia.index'))->with('success','Dodano tło!');

        } catch(\Exception $e) {
            $msg = "An exception occurred while trying to create audio-background entry. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::Error($msg);
            $skybox->delete();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SkyboxBackground  $skyboxBackground
     * @return \Illuminate\Http\Response
     */
    public function show(SkyboxBackground $skyboxBackground)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkyboxBackground  $skyboxBackground
     * @return \Illuminate\Http\Response
     */
    public function edit(SkyboxBackground $skyboxBackground)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SkyboxBackground  $skyboxBackground
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SkyboxBackground $skyboxBackground)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SkyboxBackground  $skyboxBackground
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkyboxBackground $skyboxBackground)
    {
        //
    }
}

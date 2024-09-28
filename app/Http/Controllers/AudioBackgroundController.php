<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAudioBackgroundRequest;
use App\Http\Requests\UpdateAudioBackgroundRequest;
use App\Models\AudioBackground;
use App\Models\MediaFile;
use App\Models\SkyboxBackground;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AudioBackgroundController extends Controller
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
        return view('multimedia.audio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAudioBackgroundRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(CreateAudioBackgroundRequest $request)
    {
        try{
            //dd($request);
            $audio = AudioBackground::create($request->validated());
            if($request->hasFile('background_audio')){
                $attributes = $request
                    ->merge([
                        'file' => $request->background_audio,
                        'audio' => $audio->id
                    ])
                    ->validate([
                        'file' => 'nullable|file|mimes:mp3,wav,ogg|max:51200',
                        'audio' => 'required',
                        Rule::exists('media_files','id')
                    ]);
                $mediaFile = MediaFile::create($attributes);
                $audio->media_file_id = $mediaFile->id;
                $audio->save();
            }
            return redirect(route('multimedia.index'))->with('success','Dodano tło muzyczne!');

        } catch(\Exception $e) {
            $msg = "An exception occurred while trying to create organization entry. Exception message: ".$e->getMessage();
            error_log($msg);
            Log::Error($msg);
            $audio->delete();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param AudioBackground $audioBackground
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(AudioBackground $audioBackground)
    {
        return view('multimedia.audio.show', [
            'audio' => $audioBackground
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AudioBackground $audioBackground
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(AudioBackground $audioBackground)
    {
        return view('multimedia.audio.edit', [
            'audio' => $audioBackground
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAudioBackgroundRequest $request
     * @param AudioBackground $audioBackground
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(UpdateAudioBackgroundRequest $request, AudioBackground $audioBackground)
    {
        $audioBackground->update($request->validated());
        return view('multimedia.audio.show',[
            'audio' => $audioBackground
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AudioBackground $audioBackground
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy(AudioBackground $audioBackground)
    {
        $audioBackground->delete();
        return view('multimedia.index',[
            'audios' => AudioBackground::all(),
            'skybox' => SkyboxBackground::all()
        ]);
    }
}

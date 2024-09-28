<?php

namespace App\Http\Controllers;

use App\Models\AudioBackground;
use App\Models\SkyboxBackground;

class MultimediaController extends Controller
{

    public function index()
    {
        return view('multimedia.index', [
            'audios' => AudioBackground::all(),
            'skyboxes' => SkyboxBackground::all()
        ]);
    }
}

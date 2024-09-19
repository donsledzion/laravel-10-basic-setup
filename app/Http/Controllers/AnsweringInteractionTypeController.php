<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnsweringInteractionRequest;
use App\Http\Requests\UpdateAnsweringInteractionRequest;
use App\Models\AnsweringInteractionType;

class AnsweringInteractionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('answering-interactions.index',[
            'interactions' => AnsweringInteractionType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('answering-interactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(CreateAnsweringInteractionRequest $request)
    {
        AnsweringInteractionType::create($request->validated());
        return view('answering-interactions.index',[
            'interactions' => AnsweringInteractionType::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnsweringInteractionType  $answeringInteractionType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(AnsweringInteractionType $answeringInteractionType)
    {
        return view('answering-interactions.show',[
            'interaction' => $answeringInteractionType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnsweringInteractionType  $answeringInteractionType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(AnsweringInteractionType $answeringInteractionType)
    {
        return view('answering-interactions.edit',[
           'interaction' => $answeringInteractionType
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnsweringInteractionType  $answeringInteractionType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(UpdateAnsweringInteractionRequest $request, AnsweringInteractionType $answeringInteractionType)
    {
        $answeringInteractionType->update($request->validated());
        return view('answering-interactions.index',[
            'interactions' => AnsweringInteractionType::all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnsweringInteractionType  $answeringInteractionType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy(AnsweringInteractionType $answeringInteractionType)
    {
        $answeringInteractionType->delete();
        return view('answering-interactions.index',[
            'interactions' => AnsweringInteractionType::all()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnsweringInteractionRequest;
use App\Http\Requests\UpdateAnsweringInteractionRequest;
use App\Models\AnsweringInteractionType;
use App\Models\OrganizationToken;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnsweringInteractionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if($request->is('api/*')){
            error_log('got indexAPI request hit');
            return $this->indexAPI($request);
        }
        return view('answering-interactions.index',[
            'interactions' => AnsweringInteractionType::all()
        ]);
    }

    private function indexAPI(Request $request)
    {
        error_log("device: ".$request->device);
        error_log("token: ".$request->token);
        $token = OrganizationToken::where('device',$request->device)->where('token',$request->token)->first();
        if($token != null){
            error_log('token found. Expires at: '.$token->organization->expires_at);
            if(Carbon::parse($token->organization->epixres_at)->format("YY-mm-dd")<(Carbon::now()->format("YY-mm-dd"))){
                error_log('token expired');
                $msg = 'license for organization '.$token->organization->name.' expired '.(Carbon::parse($token->organization->expires_at)->diffInDays(Carbon::now())).' days ago';
                error_log($msg);
                return response()->json([
                    'status' => 'error',
                    'message' => $msg
                ])->setStatusCode(206);
            }
            error_log('token is ok');

            return response()->json(AnsweringInteractionType::all());
        } else {
            error_log("Failed to login. Invalid token!");
            return response()->json(['fail']);
        }
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

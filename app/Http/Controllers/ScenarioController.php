<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScenarioRequest;
use App\Http\Requests\UpdateScenarioRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Scenario;
use App\Models\Organization;
use App\Models\OrganizationToken;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ScenarioController extends Controller
{
    public function index(Request $request)
    {
        if($request->is('api/*')){
            return $this->indexAPI($request);
        }

        if(\Auth::user()->isAdmin())
            $scenarios = Scenario::all();
        else
            $scenarios = \Auth::user()->scenarios;

        return view('scenarios.index',[
            'scenarios' => $scenarios
        ]);
    }

    private function indexAPI(Request $request)
    {
        error_log("device: ".$request->device);
        error_log("token: ".$request->token);
        $token = OrganizationToken::where('device',$request->device)->where('token',$request->token)->first();
        if($token != null){
            if($token->organization->epixres_at < Carbon::now()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'license for organization '.$token->organization->name.' expired '.Carbon::parse($token->organization->expired_at - Carbon::now())->diffInDays().' days ago'
                ])->setStatusCode(206);
            }
            $scenarios = new Collection();
            foreach($token->organization->scenarios as $scenario)
            {
                $newScenario = $scenario;
                $quizzes = new Collection();
                foreach($scenario->quizzes as $quiz)
                {
                    $newQuiz = $quiz;
                    foreach($newQuiz->answers as $answer){
                        if($answer->order == null){
                            $answer->order = -1;
                        if($answer->answerFileMediaType() != null){
                            $answer->content = $answer->getAnswerMediaFileFullPath();
                        }
                        }
                    }
                    $newQuiz->question_audio = $quiz->getQuestionAudioFileFullPath();
                    $newQuiz->question_picture = $quiz->getQuestionPictureFileFullPath();
                    $newQuiz->answers = $quiz->answers;
                    $quizzes->push($newQuiz);
                }
                $newScenario->quizzes = $quizzes;
                $scenarios->push($newScenario);
            }

            return response()->json($scenarios);
        } else {
            error_log("Failed to login. Invalid token!");
            return response()->json(['fail']);
        }
    }

    public function create(Organization $organization)
    {
        return view('scenarios.create',[
            'organization' => $organization
        ]);
    }

    public function show(Scenario $scenario)
    {
        return view('scenarios.show',[
            'scenario' => $scenario
        ]);
    }

    public function store(CreateScenarioRequest $request)
    {
        try{
            $scenario = \Auth::user()->scenarios()->make($request->validated());
            $scenario->organization_id = $request->organization_id;
            $scenario->save();

            return redirect(route('scenario.show',[$scenario]));
        }catch(\Exception $e){
            $msg = "An error occured while trying to store scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }

    }

    public function edit(Scenario $scenario)
    {
        return view('scenarios.edit',[
            'scenario' => $scenario
        ]);
    }

    public function update(UpdateScenarioRequest $request, Scenario $scenario)
    {
        try{
            $scenario->update($request->validated());
            return redirect(route('scenario.show',[$scenario]));
        }catch(\Exception $e){
            $msg = "An error occured while trying to update scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
        }

    }

    public function destroy(Scenario $scenario, Request $request)
    {
        try{
            $scenario->delete();
            if($request->ajax()){
                return response()->json([
                    'status' => 'ok',
                    'message' => 'deleted'
                ])->setStatusCode(200);
            }
            return redirect(route('scenario.index'));

        }catch(\Exception $e){
            $msg = "An error occured while trying to delete scenario: ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            if($request->ajax()){
                return response()->json([
                    'status' => 'error',
                    'message' => $msg
                ])->setStatusCode(200);
            }
        }
    }
}

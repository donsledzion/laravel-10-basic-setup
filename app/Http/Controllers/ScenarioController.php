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
use Illuminate\Support\Str;

class ScenarioController extends Controller
{
    public function index(Request $request)
    {
        if($request->is('api/*')){
            error_log('got indexAPI request hit');
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
            $scenarios = new Collection();
            foreach($token->organization->scenarios as $scenario)
            {
                $newScenario = $scenario;
                /*$logoFile = $scenario->getLogoFile();
                if($logoFile == null || Str::emtpy($logoFile->logo)){
                    $logoFile = $scenario->organization->getLogoFile();
                }*/
                //$newScenario->logo = $scenario->getLogoFile();

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
            if($request->hasFile('logo')){
                $this->storeLogoFile($request->file('logo'), $scenario);
            }

            return redirect(route('scenario.show',[$scenario]));
        }catch(\Exception $e){
            $msg = "An error occurred while trying to store scenario: ".$e->getMessage();
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
            $old_logo = $scenario->logo;
            $scenario->update($request->validated());
            if($request->hasFile('logo')){
                if($this->storeLogoFile($request->file('logo'), $scenario))
                    try {
                        $scenario->removeLogoFile($old_logo);
                    } catch(\Exception $e) {
                        $msg = "An error occurred while trying to remove logo file: ".$e->getMessage();
                        error_log($msg);
                        Log::error($msg);
                    }


            }
            return redirect(route('scenario.show',[$scenario]));
        }catch(\Exception $e){
            $msg = "An error occurred while trying to update scenario: ".$e->getMessage();
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

    private function storeLogoFile($file, Scenario $scenario):bool
    {
        try{
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $file->storeAs('multimedia/'.$scenario->organization->id.'/pictures/', $hashName);
            $scenario->logo = $hashName;
            $scenario->save();
            return true;
        } catch(\Exception $e){
            $msg = "Failed to store logo file! ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return false;
        }
    }
}

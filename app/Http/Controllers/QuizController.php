<?php

namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\Quiz;
use App\Http\Requests\CreateQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Enums\MediaTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function create(Scenario $scenario)
    {
        return view('quizzes.create',[
            'scenario' => $scenario
        ]);
    }


    public function store(CreateQuizRequest $request, Scenario $scenario)
    {
        //dd($request);
        $quiz = $scenario->quizzes()->create(
            $request->validated()
        );
        $media_type = $quiz->questionFileMediaType();
        
        if($media_type != null){
            if($media_type == MediaTypes::PICTURE){
                if($request->hasFile('question_picture')){
                    $quiz->question_picture = $this->storeQuizFile($request->file('question_picture'),$media_type,$quiz);
                }                
            } elseif($media_type == MediaTypes::AUDIO){
                if($request->hasFile('question_audio')){
                    $quiz->question_audio = $this->storeQuizFile($request->file('question_audio'),$media_type,$quiz);
                } 
            }
            $quiz->save();
        }
        
        return redirect(route('quiz.show',$quiz));

    }

    public function show(Quiz $quiz)
    {        
        return view('quizzes.show',[
            'quiz' => $quiz
        ]);
    }

    private function storeQuizFile($file, MediaTypes $type, Quiz $quiz):string
    {
        try{
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $file->storeAs('multimedia/'.$quiz->scenario->organization->id.'/'.$type->value.'s/', $hashName);            
            return $hashName;
        } catch(\Exception $e){
            $msg = "Failed to store quiz media file! ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return '';
        }
    }

    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit',[
            'quiz' => $quiz
        ]);
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());
        $media_type = $quiz->questionFileMediaType();
        if($media_type != null){
            if($media_type == MediaTypes::PICTURE){
                if($request->hasFile('question_picture')){
                    $quiz->removeMediaFile();
                    $quiz->question_picture = $this->storeQuizFile($request->file('question_picture'),$media_type,$quiz);
                }                
            } elseif($media_type == MediaTypes::AUDIO){
                if($request->hasFile('question_audio')){
                    $quiz->removeMediaFile();
                    $quiz->question_audio = $this->storeQuizFile($request->file('question_audio'),$media_type,$quiz);
                } 
            }
            $quiz->save();
        }

        return redirect(route('quiz.show',$quiz));
    }

    public function destroy(Request $request, Quiz $quiz)
    {
        try{
            $scenario = $quiz->scenario;
            $quiz->removeMediaFile();
            $quiz->delete();
            if($request->ajax()){
                return response()->json([
                    'status' => 'ok',
                    'message' => 'deleted',
                    'redirect' => route('scenario.show',$scenario),
                ])->setStatusCode(200);
            }
            return redirect(route('scenario.show',[$scenario]));
        } catch(\Exception $e){
            $msg = "An error occured while trying to remove quiz. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            if($request->ajax()){
                return response()->json([
                    'status' => 'error',
                    'message' => $msg,
                    'redirect' => route('scenario.show',$scenario),
                ])->setStatusCode(200);
            }
            return redirect(route('scenario.show',[$scenario]));
        }
    }
}

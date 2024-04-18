<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Enums\MediaTypes;
use App\Http\Requests\CreateAnswerRequest;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(CreateAnswerRequest $request, Quiz $quiz)
    {
        //dd($request);
        $answer = $quiz->answers()->create($request->validated());
        $media_type = $quiz->answerFileMediaType();

        if($media_type != null){
            if($request->hasFile('content')){
                $answer->content = $this->storeAnswerFile($request->file('content'),$media_type,$answer);
                $answer->save();
            }
        }
        return redirect(route('quiz.show',[$quiz]));
    }

    private function storeAnswerFile($file, MediaTypes $type, Answer $answer):string
    {
        try{
            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $hashName = hash('sha256',$fileName).'.'.$ext;
            $file->storeAs('multimedia/'.$answer->quiz->scenario->organization->id.'/'.$type->value.'s/', $hashName);            
            return $hashName;
        } catch(\Exception $e){
            $msg = "Failed to store quiz media file! ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            return '';
        }
    }

    public function destroy(Request $request, Answer $answer)
    {
        try{
            error_log("Answer: ". $answer->content);
            $quiz = $answer->quiz;
            $answer->delete();
            if($request->ajax()){
                return response()->json([
                    'status' => 'ok',
                    'message' => 'deleted',
                ])->setStatusCode(200);
            }
            return redirect(route('quiz.show',[$quiz]));
        } catch(\Exception $e){
            $msg = "An error occured while trying to remove answer. ".$e->getMessage();
            error_log($msg);
            Log::error($msg);
            if($request->ajax()){
                return response()->json([
                    'status' => 'error',
                    'message' => $msg,
                ])->setStatusCode(200);
            }
            return redirect(route('quiz.show',[$quiz]));
        }
    }

}

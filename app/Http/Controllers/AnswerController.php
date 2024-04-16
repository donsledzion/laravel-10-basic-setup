<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Enums\MediaTypes;
use App\Http\Requests\CreateAnswerRequest;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;

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
}

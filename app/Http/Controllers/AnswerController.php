<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Enums\MediaTypes;
use App\Enums\QuizTypes;
use App\Http\Requests\CreateAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(CreateAnswerRequest $request, Quiz $quiz)
    {

        $answer = $quiz->answers()->create($request->validated());
        $media_type = $quiz->answerFileMediaType();

        if($media_type != null){
            if($request->hasFile('content')){
                $answer->content = $this->storeAnswerFile($request->file('content'),$media_type,$answer);
                $answer->save();
            }
        }
        if($quiz->type == QuizTypes::PUT_IN_ORDER){
            $lastOrder = $quiz->answers->sortByDesc('order')->first()->order;
            $lastOrder++;
            $answer->order = $lastOrder;
            $answer->save();
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

    public function edit(Answer $answer)
    {
        return view('answers.edit',[
            'answer' => $answer
        ]);
    }

    public function update(UpdateAnswerRequest $request, Answer $answer)
    {

        $media_type = $answer->quiz->answerFileMediaType();
        if($media_type != null){
            if($request->hasFile('content')){
                $answer->removeMediaFile();
                $answer->content = $this->storeAnswerFile($request->file('content'),$media_type,$answer);
            }
        } elseif($request->has('content')){
            $answer->content = $request->content;
        }
        $answer->is_correct = $request->has('is_correct');
        $answer->save();
        return redirect(route('quiz.show',$answer->quiz));
    }

    public function destroy(Request $request, Answer $answer)
    {
        try{
            error_log("Answer: ". $answer->content);
            $quiz = $answer->quiz;
            $answer->delete();
            $answer->quiz->reorderAnswers();
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

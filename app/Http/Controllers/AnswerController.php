<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAnswerRequest;

class AnswerController extends Controller
{
    public function store(CreateAnswerRequest $request, Quiz $quiz)
    {
        //dd($request);
        $quiz->answers()->create($request->validated());
        return redirect(route('quiz.show',[$quiz]));
    }
}

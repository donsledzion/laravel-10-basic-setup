<?php

namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\Quiz;
use App\Http\Requests\CreateQuizRequest;
use Illuminate\Http\Request;

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
        $scenario->quizzes()->attach(
            $quiz_id = Quiz::insertGetId($request->validated())
        );
        return redirect(route('quiz.show',$quiz_id));

    }

    public function show(Quiz $quiz)
    {
        return view('quizzes.show',[
            'quiz' => $quiz
        ]);
    }
}

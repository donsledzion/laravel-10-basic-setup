<?php

namespace App\Providers;

use App\Models\Answer;
use Illuminate\Support\ServiceProvider;
use App\Models\Quiz;
use App\Models\Scenario;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Quiz::deleting(function($quiz){
            foreach($quiz->answers as $answer){
                $answer->delete();
            }
            $quiz->removeMediaFile();
        });

        Scenario::deleting(function($scenario){
            foreach($scenario->quizzes as $quiz){
                $quiz->delete();
            }
        });

        Answer::deleting(function($answer){
            $answer->removeMediaFile();
        });

    }
}

<?php

namespace App\Providers;

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
            $quiz->removeMediaFile();
        });

        Scenario::deleting(function($scenario){
            foreach($scenario->quizzes as $quiz){
                $quiz->delete();
            }
        });
    }
}

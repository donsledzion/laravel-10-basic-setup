<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Quiz;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Quiz::deleting(function($quiz){
            $quiz->removeMediaFile();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

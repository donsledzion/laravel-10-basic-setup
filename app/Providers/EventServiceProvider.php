<?php

namespace App\Providers;

use App\Models\MediaFile;
use App\Models\Organization;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        User::creating(function($user){
            if($user->password === "" || empty($user->password)){
                $user->password  = Hash::make(Str::random(10));
            }
        });

        MediaFile::deleting(function($mediaFile){
            if(Storage::exists($mediaFile->getMediaPath()))
                Storage::delete($mediaFile->getMediaPatch());
        });

        Organization::deleting(function($organization){
            $organization->logo->delete();
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

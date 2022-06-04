<?php

namespace App\Providers;

use App\Events\ModelChanged;
use App\Events\ModelCreated;
use App\Events\ModelUpdated;
use App\Events\ModelDeleted;
use App\Listeners\LogInsertion;
use App\Listeners\ModelCreatedLogInsertion;
use App\Listeners\ModelDeletedLogInsertion;
use App\Listeners\ModelUpdatedLogInsertion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ModelCreated::class => [
            ModelCreatedLogInsertion::class,
        ],
        ModelUpdated::class => [
            ModelUpdatedLogInsertion::class,
        ],
        ModelDeleted::class => [
            ModelDeletedLogInsertion::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            ModelChanged::class,
            [LogInsertion::class, 'handle']
        );
    }
}

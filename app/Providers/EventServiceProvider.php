<?php

namespace App\Providers;

use App\Events\ModelChanged;
use App\Events\ModelCreated;
use App\Events\ModelUpdated;
use App\Events\ModelDeleted;
use App\Events\ModelForceDeleted;
use App\Events\ModelTrashed;
use App\Listeners\ModelCreatedLogInsertion;
use App\Listeners\ModelDeletedLogInsertion;
use App\Listeners\ModelForceDeletedLogInsertion;
use App\Listeners\ModelTrashedLogInsertion;
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
        // 論理削除
        ModelTrashed::class => [
            ModelTrashedLogInsertion::class,
        ],
        // 論理削除を使用しているときの物理削除
        ModelForceDeleted::class => [
            ModelForceDeletedLogInsertion::class,
        ],
        // 論理削除を使用していないときの削除(物理削除)
        ModelDeleted::class => [
            ModelDeletedLogInsertion::class,
        ],
    ];
}

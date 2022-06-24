<?php

namespace App\Listeners;

use App\Events\ModelForceDeleted;
use App\Models\ModelLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelForceDeletedLogInsertion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ModelForceDeleted  $event
     * @return void
     */
    public function handle(ModelForceDeleted $event)
    {
        $model = $event->model;

        ModelLog::create([
            'user_id'        => \Auth::id() ?? null,
            'table_name'     => $model->getTable(),
            'table_pk'       => $model->id,
            'type'           => ModelLog::TYPE_FORCE_DELETE,
            'old_attributes' => json_encode( $model->getOriginal() ),
            'new_attributes' => null,
        ]);
    }
}

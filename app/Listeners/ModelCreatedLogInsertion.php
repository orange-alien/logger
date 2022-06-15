<?php

namespace App\Listeners;

use App\Events\ModelCreated;
use App\Models\ModelLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelCreatedLogInsertion
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
     * @param  \App\Events\ModelCreated $event
     * @return void
     */
    public function handle(ModelCreated $event)
    {
        $model = $event->model;

        // 変更前後の値
        $oldAttributes = null;
        $newAttributes = $model->getAttributes();

        ModelLog::create([
            'user_id'        => \Auth::id() ?? null,
            'table_name'     => $model->getTable(),
            'table_pk'       => $model->id,
            'type'           => ModelLog::TYPE_CREATED,
            'old_attributes' => $oldAttributes,
            'new_attributes' => json_encode($newAttributes),
        ]);
    }
}

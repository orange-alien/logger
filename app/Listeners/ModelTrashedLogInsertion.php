<?php

namespace App\Listeners;

use App\Events\ModelTrashed;
use App\Models\ModelLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelTrashedLogInsertion
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
     * @param \App\Events\ModelTrashed  $event
     * @return void
     */
    public function handle(ModelTrashed $event)
    {
        $model = $event->model;

        // 変更前後の値
        $deletedAtColumn = $model->getDeletedAtColumn();
        $oldAttributes = [
            $deletedAtColumn => null
        ];
        $newAttributes = [
            $deletedAtColumn => $model->getAttribute($deletedAtColumn)
        ];

        ModelLog::create([
            'user_id'        => \Auth::id() ?? null,
            'table_name'     => $model->getTable(),
            'table_pk'       => $model->id,
            'type'           => ModelLog::TYPE_TRASHED,
            'old_attributes' => json_encode($oldAttributes),
            'new_attributes' => isset($newAttributes)
                                    ? json_encode($newAttributes)
                                    : null,
        ]);
    }
}

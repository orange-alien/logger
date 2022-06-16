<?php

namespace App\Listeners;

use App\Events\ModelDeleted;
use App\Models\ModelLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelDeletedLogInsertion
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
     * @param  \App\Events\ModelDeleted $event
     * @return void
     */
    public function handle(ModelDeleted $event)
    {
        $model = $event->model;

        // 論理削除
        if( $model->exists ) {
            $deletedAtColumn = $model->getDeletedAtColumn();
            
            $oldAttributes = [
                $deletedAtColumn => null
            ];
            $newAttributes = [
                $deletedAtColumn => $model->getAttribute($deletedAtColumn)
            ];
        }
        // 物理削除
        else {
            $oldAttributes = $model->getOriginal();
            $newAttributes = null;
        }

        ModelLog::create([
            'user_id'        => \Auth::id() ?? null,
            'table_name'     => $model->getTable(),
            'table_pk'       => $model->id,
            'type'           => $model->exists
                                    ? ModelLog::TYPE_SOFT_DELETE
                                    : ModelLog::TYPE_DELETE,
            'old_attributes' => json_encode($oldAttributes),
            'new_attributes' => isset($newAttributes)
                                    ? json_encode($newAttributes)
                                    : null,
        ]);
    }
}

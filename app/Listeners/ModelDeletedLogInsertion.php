<?php

namespace App\Listeners;

use App\Events\ModelDeleted;
use App\Models\ModelLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Database\Eloquent\SoftDeletes;

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

        // 論理削除使用時は trashed, forceDeleted イベントで処理するので deleted では処理しない
        $hasSoftDeletesTrait = in_array(SoftDeletes::class, class_uses($model), true);
        if( $hasSoftDeletesTrait ) {
            return;
        }

        ModelLog::create([
            'user_id'        => \Auth::id() ?? null,
            'table_name'     => $model->getTable(),
            'table_pk'       => $model->id,
            'type'           => ModelLog::TYPE_DELETE,
            'old_attributes' => json_encode( $model->getOriginal() ),
            'new_attributes' => null,
        ]);
    }
}

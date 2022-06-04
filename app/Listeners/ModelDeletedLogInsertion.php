<?php

namespace App\Listeners;

use App\Events\ModelDeleted;
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
        \Log::debug('==== 削除 ====');

        $model = $event->model;

        // 論理削除
        if( $model->exists ) {
            \Log::debug('=> 論理削除');
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
            \Log::debug('=> 物理削除');
            $oldAttributes = $model->getOriginal();
            $newAttributes = null;
        }

        \Log::debug($oldAttributes);
        \Log::debug($newAttributes);
    }
}

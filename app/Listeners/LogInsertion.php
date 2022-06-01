<?php

namespace App\Listeners;

use App\Events\ModelChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;

class LogInsertion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $model = $event->model;

        // 新規作成
        if($model->wasRecentlyCreated) { // wasRecentlyCreated が trueかつ、originalsが空のとき
            \Log::debug('===== 新規作成 =====');
            // 変更前の値
            \Log::debug( null );
            // 変更後の値
            \Log::debug( $model->getAttributes() );
        }
        // 削除(論理削除)
        //       物理削除の判定は SoftDeletes トレイトの isForceDeleting() で判定する必要がある(はず)
        else if(!$model->exists) {
            \Log::debug('===== 削除 =====');
            
            // 変更前の値
            \Log::debug( null );
            // 変更後の値
            $deletedAtColumn = $model->getDeletedAtColumn();
            \Log::debug( $model->getAttribute($deletedAtColumn) );
        }
        // 更新
        else {
            \Log::debug('===== 更新 =====');
            $changes = $model->getChanges();
            $changeKyes = array_keys($changes);

            // 変更前の値
            \Log::debug( Arr::only($model->getOriginal(), $changeKyes) );
            // 変更後の値
            \Log::debug( $changes );
        }
    }
}

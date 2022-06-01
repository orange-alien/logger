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
        else if(!$model->exists) {
            \Log::debug('===== 削除 =====');
            
            // 変更前の値
            \Log::debug( null );
            // 変更後の値
            //   物理削除時(SoftDeletesトレイトを使用していないとき)は getDeletedAtColumn() でエラーになるので別途考慮が必要 
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

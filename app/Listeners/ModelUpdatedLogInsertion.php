<?php

namespace App\Listeners;

use App\Events\ModelUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelUpdatedLogInsertion
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
     * @param  \App\Events\ModelUpdated  $event
     * @return void
     */
    public function handle(ModelUpdated $event)
    {
        \Log::debug('===== 更新 =====');

        $model = $event->model;

        // 変後の値
        $newAttributes = $model->getChanges();
        
        // 変更前の値
        //    【注意】以下の手順でイベントを発火する場合、$model の $original は
        //           既に $attributes で上書きされてしまっているので更新前の値は取得できない
        //               => Model の更新処理の最後に $this->syncOriginal() が実行されるため
        //            $model->update([...]); もしくは $model->save();
        //            ModelUpdated::dispatch($model);
        $newAttributeKeys = array_keys($newAttributes);
        $oldAttributes = \Arr::only($model->getOriginal(), $newAttributeKeys);

        \Log::debug($oldAttributes);
        \Log::debug($newAttributes);
    }
}

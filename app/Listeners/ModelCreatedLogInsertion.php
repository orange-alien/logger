<?php

namespace App\Listeners;

use App\Events\ModelCreated;
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
        \Log::debug('===== 新規作成 =====');

        $model = $event->model;

        // 変更前後の値
        $oldAttributes = null;
        $newAttributes = $model->getAttributes();
        \Log::debug($oldAttributes);
        \Log::debug($newAttributes);
    }
}

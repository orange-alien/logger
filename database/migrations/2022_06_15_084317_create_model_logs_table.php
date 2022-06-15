<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Support\Facades\Schema;

class CreateModelLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('model_logs');

        Schema::create('model_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->comment('ログID');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('対象レコードのPK');
            $table->string('table_name', 255)->comment('対象テーブル');
            $table->unsignedBigInteger('table_pk')->comment('対象レコードのPK');
            $table->unsignedTinyInteger('type')->comment('ログ種別 1:登録, 2:更新, 3:論理削除, 4:論理削除解除, 5:物理削除');
            $table->json('old_attributes')->nullable()->comment('変更前の値');
            $table->json('new_attributes')->nullable()->comment('変更後の値');
            $table->timestamps();

            $table->primary(['id', 'created_at']);
            $table->index(['table_name', 'table_pk']);
        });

        Schema::table('model_logs', function(Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_logs');
    }
}

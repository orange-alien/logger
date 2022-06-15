<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{
    use HasFactory;

    // ログ種別
    const TYPE_CREATED       = 1; // 登録
    const TYPE_UPDATED       = 2; // 更新
    const TYPE_SOFT_DELETED  = 3; // 論理削除
    const TYPE_RESTORED      = 4; // 論理削除解除
    const TYPE_DELETD        = 5; // 物理削除

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'table_name',
        'table_pk',
        'type',
        'old_attributes',
        'new_attributes',
    ];
}

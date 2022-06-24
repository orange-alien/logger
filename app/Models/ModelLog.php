<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{
    use HasFactory;

    // ログ種別
    const TYPE_CREATE       = 1; // 登録
    const TYPE_UPDATE       = 2; // 更新
    const TYPE_TRASHED      = 3; // 論理削除
    const TYPE_RESTORE      = 4; // 論理削除解除
    const TYPE_DELETE       = 5; // 削除(論理削除未使用時)
    const TYPE_FORCE_DELETE = 6; // 削除(論理削除使用時)

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

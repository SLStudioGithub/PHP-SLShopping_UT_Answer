<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理者役割情報モデル
 */
class AdminRole extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'admin_roles';

    /**
     * テーブルの主キー
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];
}

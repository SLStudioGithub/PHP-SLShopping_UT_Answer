<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理者権限情報中間モデル
 */
class AdminUserPermission extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'admin_user_permissions';

    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'permission_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理者役割情報中間モデル
 */
class AdminRoleUser extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'admin_role_users';

    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'user_id',
    ];
}

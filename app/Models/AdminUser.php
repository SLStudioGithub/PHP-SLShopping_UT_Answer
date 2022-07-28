<?php

namespace App\Models;

use App\Admin\Exceptions\NotFoundException;
use App\Consts\PageConsts;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
// use Illuminate\Contracts\Auth\Authenticatable;
/**
 * 管理者情報モデル
 */
class AdminUser extends Authenticatable
{
    use Notifiable;

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'admin_users';

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
        'username',
        'password',
        'name',
        'avatar',
    ];

    /**
     * admin_rolesとの多対多リレーション定義
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\AdminRole', 'admin_role_users', 'user_id', 'role_id');
    }

    /**
     * admin_permissionsとの多対多リレーション定義
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\AdminPermission', 'admin_user_permissions', 'user_id', 'permission_id');
    }

    /**
     * 管理者の役割を全件取得する
     *
     * @return Collection
     */
    public function getAllRoles()
    {
        return AdminRole::all();
    }

    /**
     * 管理者権限を全件取得する
     *
     * @return Collection
     */
    public function getAllPermissions()
    {
        return AdminPermission::all();
    }

    /**
     * 管理者の検索と取得
     *
     * @param string|null $userId
     * @param string|null $userName
     * @param array|null $roleIds
     * @param array|null $permissionIds
     * @return LengthAwarePaginator
     */
    public function search($userId, $userName, $roleIds, $permissionIds)
    {
        // 役割IDがない場合は全役割を検索条件とする
        $roleIds = $roleIds ? $roleIds : $this->getAllRoles()
            ->map(function (AdminRole $role) {
                return $role->id;
            })
            ->toArray();
        // 権限IDがない場合は全権限を検索条件とする
        $permissionIds = $permissionIds ? $permissionIds : $this->getAllPermissions()
            ->map(function (AdminPermission $permission) {
                return $permission->id;
            })
            ->toArray();
        return $this->fetch(
            $userId,
            $userName,
            $roleIds,
            $permissionIds
        );
    }

    /**
     * admin_usersテーブルで検索と取得
     *
     * @param string|null $userId
     * @param string|null $userName
     * @param array $roleIds
     * @param array $permissionIds
     * @return LengthAwarePaginator
     */
    public function fetch($userId, $userName, $roleIds, $permissionIds)
    {
        $adminUsers = AdminUser::query()
            ->where('username', 'like', "%$userId%") // 管理者IDはあいまい検索
            ->where('name', 'like', "%$userName%") // 管理者名はあいまい検索
            ->whereHas('roles', function ($query) use ($roleIds) {
                // 役割IDは複数検索
                $query->whereIn('id', $roleIds);
            })
            ->whereHas('permissions', function ($query) use ($permissionIds) {
                // 権限IDは複数検索
                $query->whereIn('id', $permissionIds);
            })
            ->paginate(PageConsts::ADMIN_NUMBER_OF_PER_PAGE); // 1ページあたり20件表示
        return $adminUsers;
    }

    /**
     * 管理者の新規作成
     *
     * @param string $userId
     * @param string $userName
     * @param string $password
     * @param array $roleIds
     * @param array $permissionIds
     * @return AdminUser
     */
    public function createAdminUser($userId, $userName, $password, $roleIds, $permissionIds)
    {
        $adminUser = new AdminUser([
            'username' => $userId,
            'name' => $userName,
            'password' => bcrypt($password)
        ]);
        // DB永続化処理
        $adminUser = $this->saveAll(
            $adminUser,
            $roleIds,
            $permissionIds
        );
        return $adminUser;
    }

    /**
     * admin_usersテーブルデータ更新
     *
     * @param AdminUser $adminUser
     * @param array $roleIds
     * @param array $permissionIds
     * @return AdminUser
     */
    public function saveAll($adminUser, $roleIds, $permissionIds)
    {
        return DB::transaction(function () use ($adminUser, $roleIds, $permissionIds) {
            // admin_usersテーブルに上書き情報永続化
            $adminUser->save();
            // admin_user_rolesにデータのdelete＆insert
            $adminUser->roles()->sync($roleIds);
            // admin_user_permissionsにデータのdelete＆insert
            $adminUser->permissions()->sync($permissionIds);
            return $adminUser;
        });
    }

    /**
     * 管理者詳細情報を取得
     *
     * @param integer $id
     * @throws NotFoundException
     * @return AdminUser
     */
    public function findById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        // 管理者の取得
        $adminUser = AdminUser::find($id);
        return $adminUser;
    }

    /**
     * 管理者情報を更新
     *
     * @param integer $id
     * @param string $userId
     * @param string $userName
     * @param array $roleIds
     * @param array $permissionIds
     * @return AdminUser
     */
    public function edit($id, $userId, $userName, $roleIds, $permissionIds)
    {
        // 管理者情報の取得
        $adminUser = $this->findById($id);
        $adminUser->username = $userId;
        $adminUser->name = $userName;
        return $this->saveAll(
            $adminUser,
            $roleIds,
            $permissionIds
        );
    }

    /**
     * 管理者の削除
     *
     * @param integer $id
     * @return AdminUser
     */
    public function deleteById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        // 管理者情報の取得
        $adminUser = $this->findById($id);
        $this->deleteAll($adminUser);
        return $adminUser;
    }

    /**
     * admin_usersテーブルからデータ削除
     *
     * @param AdminUser $adminUser
     * @return void
     */
    public function deleteAll($adminUser)
    {
        DB::transaction(function () use ($adminUser) {
            // admin_user_permissionsテーブルのデータ削除
            $adminUser->roles()->detach();
            // admin_user_rolesテーブルのデータ削除
            $adminUser->permissions()->detach();
            // admin_usersテーブルのデータ削除
            $adminUser->delete();
        });
    }

    /**
     * 管理者の存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        if (AdminUser::whereId($id)->count() == 0) {
            return false;
        }
        return true;
    }

    /**
     * 管理者メールアドレスの重複チェック
     *
     * @param AdminUser $adminUser
     * @return boolean
     */
    public function checkUnique($adminUser)
    {
        $isCreatingNew = ($adminUser->id == null || $adminUser->id == 0);
        $adminUserByName = AdminUser::whereUsername($adminUser->username)->get();
        if ($isCreatingNew) {
            if ($adminUserByName->isNotEmpty()) {
                return false;
            }
        } else {
            if ($adminUserByName->isNotEmpty() && $adminUserByName->id != $adminUser->id) {
                return false;
            }
        }
        return true;
    }
}

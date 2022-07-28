<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\AdminUserRequest;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 管理者画面コントローラー
 *
 * 管理者画面の処理について一括で管理する。
 */
class AdminUsersController extends Controller
{
    /**
     * 管理者ユーザーモデル
     *
     * @var AdminUser $adminUser
     */
    private $adminUser;

    /**
     * コンストラクタ
     */
    public function __construct(AdminUser $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    /**
     * 管理者一覧＆検索画面
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // 検索条件用に全役割を取得
        $roles = $this->adminUser->getAllRoles();
        // 検索条件用に全権限を取得
        $permissions = $this->adminUser->getAllPermissions();
        // 管理者を検索
        $adminUsers = $this->adminUser->search(
            $request->adminUserId,
            $request->adminUserName,
            $request->adminUserRoles,
            $request->adminUserPermissions
        );
        return view('admin.admin-users.index', compact('adminUsers', 'roles', 'permissions'));
    }

    /**
     * 管理者新規登録画面
     *
     * @return View
     */
    public function showCreate()
    {
        // 登録フォーム用に全役割を取得
        $roles = $this->adminUser->getAllRoles();
        // 登録フォーム用に全権限を取得
        $permissions = $this->adminUser->getAllPermissions();
        return view('admin.admin-users.create', compact('roles', 'permissions'));
    }

    /**
     * 管理者新規登録
     *
     * @param AdminUserRequest $request
     * @return RedirectResponse
     */
    public function create(AdminUserRequest $request)
    {
        // 管理者を新規登録＆取得
        $adminUser = $this->adminUser->createAdminUser(
            $request->userId,
            $request->userName,
            $request->password,
            $request->adminUserRoles,
            $request->adminUserPermissions
        );
        // 新規登録した管理者詳細にリダイレクトする
        return redirect()
            ->route('admin.adminUsers.detail', ['id' => $adminUser->id])
            ->with('completeFlg', true);
    }

    /**
     * 管理者詳細画面
     *
     * @param integer $id
     * @return View
     */
    public function detail($id)
    {
        // 管理者詳細情報を取得
        $adminUser = $this->adminUser->findById($id);
        return view('admin.admin-users.detail', compact('adminUser'));
    }

    /**
     * 管理者編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showEdit($id)
    {
        // フォーム用に全役割を取得
        $roles = $this->adminUser->getAllRoles();
        // フォーム用に全権限を取得
        $permissions = $this->adminUser->getAllPermissions();
        // 管理者詳細情報を取得
        $adminUser = $this->adminUser->findById($id);
        return view('admin.admin-users.edit', compact('adminUser', 'roles', 'permissions'));
    }

    /**
     * 管理者編集
     *
     * @param integer $id
     * @param AdminUserRequest $request
     * @return RedirectResponse
     */
    public function edit($id, AdminUserRequest $request)
    {
        // 管理者を編集
        $adminUser = $this->adminUser->edit(
            $id,
            $request->userId,
            $request->userName,
            $request->adminUserRoles,
            $request->adminUserPermissions
        );
        // 編集した管理者詳細にリダイレクトする
        return redirect()
            ->route('admin.adminUsers.detail', ['id' => $adminUser->id])
            ->with('completeFlg', true);
    }

    /**
     * 管理者の削除
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $adminUser = $this->adminUser->deleteById($id);
        // 一覧画面へ遷移
        return redirect()->route('admin.adminUsers.index')->with('message', "{$adminUser->name}を削除しました");
    }
}
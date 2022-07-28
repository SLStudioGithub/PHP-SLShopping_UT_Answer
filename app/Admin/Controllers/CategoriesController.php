<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * カテゴリー画面コントローラー
 *
 * カテゴリー画面の処理について一括で管理する。
 */
class CategoriesController extends Controller
{
    /**
     * カテゴリーモデル
     *
     * @var Category $category
     */
    private $category;

    /**
     * コンストラクタ
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * カテゴリー一覧＆検索画面
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // カテゴリの検索＆一覧取得
        $categories = $this->category->fetch($request->id, $request->name);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * カテゴリー詳細画面
     *
     * @param integer $id
     * @return View
     */
    public function detail($id)
    {
        // カテゴリーの詳細取得
        $category = $this->category->findById($id);
        return view('admin.categories.detail', compact('category'));
    }

    /**
     * カテゴリー新規登録画面表示
     *
     * @return View
     */
    public function showCreate()
    {
        return view('admin.categories.create');
    }

    /**
     * カテゴリー新規作成
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function create(CategoryRequest $request)
    {
        // カテゴリーを新規登録＆取得
        $category = $this->category->create($request->name);
        return redirect()
            ->route('admin.categories.detail', ['id' => $category->id])
            ->with('completeFlg', true);
    }

    /**
     * カテゴリー編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showEdit($id)
    {
        // カテゴリーの詳細情報を取得
        $category = $this->category->findById($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * カテゴリー編集
     *
     * @param integer $id
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function edit($id, CategoryRequest $request)
    {
        $category = $this->category->edit($id, $request->name);
        return redirect()
            ->route('admin.categories.detail', ['id' => $category->id])
            ->with('completeFlg', true);
    }

    /**
     * カテゴリー削除
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->category->deleteById($id);
        return redirect()->route('admin.categories.index')->with('message', "{$category->name}を削除しました");
    }
}
<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ブランド画面コントローラー
 *
 * ブランド画面の処理について一括で管理する。
 */
class BrandsController extends Controller
{
    /**
     * ブランドモデル
     *
     * @var Brand $brand
     */
    private $brand;

    /**
     * コンストラクタ
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * ブランド一覧＆検索画面
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // ブランドの検索＆一覧取得
        $brands = $this->brand->fetch($request->id, $request->name);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * ブランド詳細画面
     *
     * @param integer $id
     * @return View
     */
    public function detail($id)
    {
        // ブランドの詳細取得
        $brand = $this->brand->findById($id);
        return view('admin.brands.detail', compact('brand'));
    }

    /**
     * ブランド新規登録画面表示
     *
     * @return View
     */
    public function showCreate()
    {
        return view('admin.brands.create');
    }
    
    /**
     * ブランド新規作成
     *
     * @param BrandRequest $request
     * @return RedirectResponse
     */
    public function create(BrandRequest $request)
    {
        // ブランドを新規登録＆取得
        $brand = $this->brand->create($request->name);
        return redirect()
            ->route('admin.brands.detail', ['id' => $brand->id])
            ->with('completeFlg', true);
    }

    /**
     * ブランド編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showEdit($id)
    {
        // ブランドの詳細情報を取得
        $brand = $this->brand->findById($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * ブランド編集
     *
     * @param integer $id
     * @param BrandRequest $request
     * @return RedirectResponse
     */
    public function edit($id, BrandRequest $request)
    {
        $brand = $this->brand->edit($id, $request->name);
        return redirect()
            ->route('admin.brands.detail', ['id' => $brand->id])
            ->with('completeFlg', true);
    }

    /**
     * ブランド削除
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $brand = $this->brand->deleteById($id);
        return redirect()->route('admin.brands.index')->with('message', "{$brand->name}を削除しました");
    }
}
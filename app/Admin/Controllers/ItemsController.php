<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\ItemRequest;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 商品画面コントローラー
 *
 * 商品画面の処理について一括で管理する。
 */
class ItemsController extends Controller
{
    /**
     * 商品モデル
     *
     * @var Item $item
     */
    private $item;

    /**
     * コンストラクタ
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * 商品一覧＆検索画面
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // 商品の検索＆取得
        $items = $this->item->fetchForAdmin(
            $request->id,
            $request->name,
            $request->lowPrice,
            $request->highPrice,
            $request->brandId,
            $request->categoryId
        );
        // 全ブランドの取得
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.items.index', compact('items', 'brands', 'categories'));
    }

    /**
     * 商品新規登録画面表示
     *
     * @return View
     */
    public function showCreate()
    {
        // 全ブランドの取得
        $brands = Brand::all();
        // 全カテゴリーの取得
        $categories = Category::all();
        return view('admin.items.create', compact('brands', 'categories'));
    }

    /**
     * 商品新規登録
     *
     * @param ItemRequest $request
     * @return RedirectResponse
     */
    public function create(ItemRequest $request)
    {
        // 商品の作成
        $item = $this->item->create(
            $request->name,
            $request->description,
            $request->price,
            $request->brandId,
            $request->categoryId,
        );
        // 作成した商品の詳細画面へ遷移
        return redirect()
            ->route('admin.items.detail', ['id' => $item->id])
            ->with('completeFlg', true);
    }

    /**
     * 商品詳細画面
     *
     * @param integer $id
     * @return View
     */
    public function detail($id)
    {
        // 商品詳細取得
        $item = $this->item->findById($id);
        return view('admin.items.detail', compact('item'));
    }

    /**
     * 商品編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showEdit($id)
    {
        // 商品詳細取得
        $item = $this->item->findById($id);
        // 全ブランドの取得
        $brands = Brand::all();
        // 全カテゴリーの取得
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'brands', 'categories'));
    }

    /**
     * 商品編集
     *
     * @param ItemRequest $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function edit(ItemRequest $request, $id)
    {
        // 商品の編集
        $item = $this->item->edit(
            $id,
            $request->name,
            $request->description,
            $request->price,
            $request->brandId,
            $request->categoryId,
        );
        return redirect()
            ->route('admin.items.detail', ['id' => $item->id])
            ->with('completeFlg', true);
    }

    /**
     * 商品削除
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $item = $this->item->deleteById($id);
        // 一覧画面へ遷移
        return redirect()->route('admin.items.index')->with('message', "{$item->name}を削除しました");
    }
}
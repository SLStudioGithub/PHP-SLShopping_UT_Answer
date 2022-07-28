<?php

namespace App\Models;

use App\Admin\Exceptions\NotFoundException;
use App\Consts\PageConsts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 商品情報モデル
 */
class Item extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'items';

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
        'description',
        'price',
        'brand_id',
        'category_id',
    ];

    /**
     * brandsとの多対１リレーション定義
     *
     * @return belongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * categoriesとの多対１リレーション定義
     *
     * @return belongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 管理向けの検索＆取得
     *
     * @param integer|null $id
     * @param string|null $name
     * @param integer $lowPrice
     * @param integer $highPrice
     * @param integer|null $brandId
     * @param integer|null $categoryId
     * @return LengthAwarePaginator
     */
    public function fetchForAdmin(
        $id,
        $name,
        $lowPrice,
        $highPrice,
        $brandId,
        $categoryId
    )
    {
        // 下限金額はnullの時0を指定
        $lowPrice = is_null($lowPrice) ? 0 : $lowPrice;
        // 上限金額はnullの時1000000を指定
        $highPrice = is_null($highPrice) ? 1000000 : $highPrice;

        // joinのクエリを取得
        $query = Item::query();
        if (!is_null($id)) {
            $query->where('items.id', $id); // IDは完全一致
        }
        if (!is_null($name)) {
            $query->where('items.name', 'like', "%$name%"); // 名前はあいまい検索
        }
        if (!is_null($brandId)) {
            $query->where('items.brand_id', $brandId);
        }
        if (!is_null($categoryId)) {
            $query->where('items.category_id', $categoryId); // 親カテゴリーをjoinした情報から探す
        }
        $items = $query->whereBetween('items.price', [$lowPrice, $highPrice]) // 金額は範囲検索
            ->groupBy('items.id')
            ->orderBy('items.id') // 商品IDでソート
            ->paginate(PageConsts::ADMIN_NUMBER_OF_PER_PAGE);
        return $items;
    }

    /**
     * itemsテーブルの詳細情報をIDで取得
     *
     * @param integer $id
     * @return Item
     */
    public function findById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        // クエリを取得
        $query = Item::query();
        // IDで検索して最初のデータを取得
        $item = $query->groupBy('id')
            ->where('id', $id)
            ->where('deleted_at', null)
            ->first();
        return $item;
    }

    /**
     * 商品の新規作成
     *
     * @param string $name
     * @param string $description
     * @param integer $price
     * @param integer $brandId
     * @param integer $categoryId
     * @return Item
     */
    public function create(
        $name,
        $description,
        $price,
        $brandId,
        $categoryId
    )
    {
        // 商品情報の作成(stockは0で作成)
        $item = new Item([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'brand_id' => $brandId,
            'category_id' => $categoryId,
        ]);
        $item->save();
        return $item;
    }

    /**
     * 商品編集
     *
     * @param integer $id
     * @param string $name
     * @param string $description
     * @param integer $price
     * @param integer $brandId
     * @param array $categoryId
     * @return Item
     */
    public function edit(
        $id,
        $name,
        $description,
        $price,
        $brandId,
        $categoryId
    )
    {
        // 商品情報の編集
        $item = $this->findById($id)->fill([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'brand_id' => $brandId,
            'category_id' => $categoryId,
        ]);
        $item->save();
        return $item;
    }

    /**
     * 商品削除
     *
     * @param integer $id
     * @throws NotDeletedException
     * @return Item
     */
    public function deleteById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        // 商品情報取得
        $item = $this->findById($id);
        $item->delete();
        return $item;
    }

    /**
     * 商品の存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        if (Item::whereId($id)->count() == 0) {
            return false;
        }
        return true;
    }

    /**
     * 商品名の重複チェック
     *
     * @param Item $brand
     * @return boolean
     */
    public function checkUnique($item)
    {
        $isCreatingNew = ($item->id == null || $item->id == 0);
        $itemByName = Item::whereName($item->name)->get();
        if ($isCreatingNew) {
            if ($itemByName->isNotEmpty()) {
                return false;
            }
        } else {
            if ($itemByName->isNotEmpty() && $itemByName->id != $item->id) {
                return false;
            }
        }
        return true;
    }
}

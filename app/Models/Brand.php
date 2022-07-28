<?php

namespace App\Models;

use App\Models\Item;
use App\Consts\PageConsts;
use App\Admin\Exceptions\NotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;

/**
 * ブランド情報モデル
 */
class Brand extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'brands';

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
    ];

    /**
     * itemsとの１対多リレーション定義
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * brandsテーブル全件取得
     *
     * @return Collection
     */
    public function findAll()
    {
        return Brand::all();
    }

    /**
     * brandsテーブルデータ検索＆取得
     *
     * @param integer|null $id
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function fetch($id, $name)
    {
        $query = Brand::query();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        if (!is_null($name)) {
            $query->where('name', 'like', "%$name%");
        }
        return $query->paginate(PageConsts::ADMIN_NUMBER_OF_PER_PAGE);
    }

    /**
     * brandsテーブルからIDでレコードを１件取得
     *
     * @param int $id
     * @return Brand
     * @throws NotFoundException
     */
    public function findById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        return Brand::find($id);
    }

    /**
     * brandsテーブルにレコードを新規登録
     *
     * @param string $name
     * @return Brand
     */
    public function create($name)
    {
        $brand = new Brand([
            'name' => $name
        ]);
        $brand->save();
        return $brand;
    }

    /**
     * brandsテーブルの該当レコードを更新
     *
     * @param int $id
     * @param string $name
     * @return Brand
     */
    public function edit($id, $name)
    {
        $brand = $this->findById($id);
        $brand->name = $name;
        $brand->save();
        return $brand;
    }

    /**
     * brandsテーブルの該当レコードを削除
     *
     * @param int $id
     * @return Brand
     * @throws NotFoundException
     */
    public function deleteById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        $brand = $this->findById($id);
        $brand->delete();
        return $brand;
    }

    /**
     * brandの存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        if (Brand::whereId($id)->count() == 0) {
            return false;
        }
        return true;
    }

    /**
     * ブランド名の重複チェック
     *
     * @param Brand $brand 重複確認したいブランド情報
     * @return boolean true:重複なし false:重複あり
     */
    public function checkUnique($brand)
    {
        $isCreatingNew = ($brand->id == null || $brand->id == 0);
        $brandByName = Brand::whereName($brand->name)->get();
        if ($isCreatingNew) {
            if ($brandByName->isNotEmpty()) {
                return false;
            }
        } else {
            if ($brandByName->isNotEmpty() && $brandByName->id != $brand->id) {
                return false;
            }
        }
        return true;
    }
}

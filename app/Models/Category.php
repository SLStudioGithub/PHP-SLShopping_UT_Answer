<?php

namespace App\Models;

use App\Models\Item;
use App\Consts\PageConsts;
use App\Admin\Exceptions\NotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * カテゴリー情報モデル
 */
class Category extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'categories';

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
     * categoriesテーブル全件取得
     *
     * @return Collection
     */
    public function findAll()
    {
        return Category::all();
    }

    /**
     * categoriesテーブルデータ検索＆取得
     *
     * @param integer|null $id
     * @param string|null $name
     * @param array|null $categories_input
     * @return LengthAwarePaginator
     */
    public function fetch($id, $name)
    {
        $query = Category::query();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        if (!is_null($name)) {
            $query->where('name', 'like', "%$name%");
        }
        return $query->paginate(PageConsts::ADMIN_NUMBER_OF_PER_PAGE);
    }

    /**
     * categoriesテーブルからIDでレコードを１件取得
     *
     * @param int $id
     * @return Category
     * @throws NotFoundException
     */
    public function findById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        return Category::find($id);
    }

    /**
     * categoriesテーブルにレコードを新規登録
     *
     * @param string $name
     * @param int $parentCategoryId
     * @return Category
     */
    public function create($name)
    {
        $category = new Category([
            'name' => $name,
        ]);
        $category->save();
        return $category;
    }

    /**
     * categoriesテーブルの該当レコードを更新
     *
     * @param int $id
     * @param string $name
     * @param int $parentCategoryId
     * @return Category
     */
    public function edit($id, $name)
    {
        $category = $this->findById($id);
        $category->name = $name;
        $category->save();
        return $category;
    }

    /**
     * categoriesテーブルの該当レコードを削除
     *
     * @param int $id
     * @return Category
     */
    public function deleteById($id)
    {
        if (!$this->exists($id)) {
            throw new NotFoundException($id, $this->getTable());
        }
        $category = $this->findById($id);
        $category->delete();
        return $category;
    }

    /**
     * brandの存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function exists($id)
    {
        if (Category::whereId($id)->count() == 0) {
            return false;
        }
        return true;
    }

    /**
     * ブランド名の重複チェック
     *
     * @param Brand $category
     * @return boolean
     */
    public function checkUnique($category)
    {
        $isCreatingNew = ($category->id == null || $category->id == 0);
        $categoryByName = Category::whereName($category->name)->get();
        if ($isCreatingNew) {
            if ($categoryByName->isNotEmpty()) {
                return false;
            }
        } else {
            if ($categoryByName->isNotEmpty() && $categoryByName->id != $category->id) {
                return false;
            }
        }
        return true;
    }
}

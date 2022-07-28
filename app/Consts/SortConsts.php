<?php

namespace App\Consts;

/**
 * ソート欄情報
 *
 * 商品一覧画面に表示するソート条件セレクトを表示するための定数
 */
class SortConsts
{
    /**
     * @var string おすすめ順ソートキー
     */
    public const SORT_TOP = 'top';

    /**
     * @var string おすすめ順ソート名
     */
    public const SORT_TOP_NAME = 'おすすめ順';

    /**
     * @var string 安い順ソートキー
     */
    public const SORT_LOW = 'low';

    /**
     * @var string 安い順ソート名
     */
    public const SORT_LOW_NAME = '安い順';

    /**
     * @var string 高い順ソートキー
     */
    public const SORT_HIGH = 'high';

    /**
     * @var string 高い順ソート名
     */
    public const SORT_HIGH_NAME = '高い順';

    /**
     * @var string 最新商品順ソートキー
     */
    public const SORT_NEW = 'new';

    /**
     * @var string 最新商品順ソート名
     */
    public const SORT_NEW_NAME = '最新商品';

    /**
     * @var array ソートキーとソート名の紐づけ
     */
    public const SORT_LIST = [
        self::SORT_TOP => self::SORT_TOP_NAME,
        self::SORT_LOW => self::SORT_LOW_NAME,
        self::SORT_HIGH => self::SORT_HIGH_NAME,
        self::SORT_NEW => self::SORT_NEW_NAME,
    ];
}
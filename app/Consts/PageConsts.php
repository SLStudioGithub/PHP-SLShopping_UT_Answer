<?php

namespace App\Consts;

/**
 * ページネーション情報
 *
 * １ページあたりの表示レコード定数
 */
class PageConsts
{
    /**
     * @var int 管理側1ページあたりの表示件数
     */
    public const ADMIN_NUMBER_OF_PER_PAGE = 20;

    /**
     * @var int shop側1ページあたりの表示件数
     */
    public const SHOP_NUMBER_OF_PER_PAGE = 24;
}
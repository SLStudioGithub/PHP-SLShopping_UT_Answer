<?php

namespace App\Admin\Exceptions;

use Illuminate\View\View;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * テーブルにデータがない場合のException
 */
class NotFoundException extends Exception
{
    /**
     * ステータスコード
     *
     * @var integer
     */
    private const STATUS_CODE = 404;

    /**
     * コンストラクタ
     *
     * @param integer $id
     * @param string $tableName
     */
    public function __construct($id, $tableName)
    {
        parent::__construct("Not Found (TableName: {$tableName}, ID: {$id})", self::STATUS_CODE);
    }

    /**
     * レスポンス指定
     *
     * @return Response
     */
    public function render()
    {
        return response()->view('admin.errors.common', ['status' => self::STATUS_CODE], self::STATUS_CODE);
    }
}

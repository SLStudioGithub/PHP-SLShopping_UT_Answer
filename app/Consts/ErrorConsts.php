<?php

namespace App\Consts;

/**
 * エラー情報
 *
 * 例外発生時のエラー画面用タイトルとメッセージの定数
 */
class ErrorConsts
{
    /**
     * @var string ステータスコード403時の表示タイトル
     */
    public const TITLE_403 = 'Forbidden';

    /**
     * @var string ステータスコード403時の表示メッセージ
     */
    public const MESSAGE_403 = 'アクセス権がありません';

    /**
     * @var string ステータスコード404時の表示タイトル
     */
    public const TITLE_404 = 'Not Found';

    /**
     * @var string ステータスコード404時の表示メッセージ
     */
    public const MESSAGE_404 = 'ページが見つかりません';

    /**
     * @var string ステータスコード419時の表示タイトル
     */
    public const TITLE_419 = 'Page Expired';

    /**
     * @var string ステータスコード403時の表示メッセージ
     */
    public const MESSAGE_419 = 'ページが期限切れです、もう一度更新してからお試しください';

    /**
     * @var string ステータスコード500時の表示タイトル
     */
    public const TITLE_500 = 'Internal Server Error';

    /**
     * @var string ステータスコード500時の表示メッセージ
     */
    public const MESSAGE_500 = 'エラーが発生しました';

    /**
     * @var string ステータスコード503時の表示タイトル
     */
    public const TITLE_503 = 'Service Unavailable';

    /**
     * @var string ステータスコード503時の表示メッセージ
     */
    public const MESSAGE_503 = '現在サービスはご利用いただけません、時間を置いてから再度お試しください';

    /**
     * @var string デフォルトの表示タイトル
     */
    public const TITLE_DEFAULT = 'Error';

    /**
     * @var string デフォルトの表示メッセージ
     */
    public const MESSAGE_DEFAULT = '予期せぬエラーが発生しました';

    /**
     * @var array ステータスコードと表示タイトルの紐づけ
     */
    public const TITLE_LIST = [
        403 => self::TITLE_403,
        404 => self::TITLE_404,
        419 => self::TITLE_419,
        500 => self::TITLE_500,
        503 => self::TITLE_503,
    ];

    /**
     * @var array ステータスコードと表示メッセージの紐づけ
     */
    public const MESSAGE_LIST = [
        403 => self::MESSAGE_403,
        404 => self::MESSAGE_404,
        419 => self::MESSAGE_419,
        500 => self::MESSAGE_500,
        503 => self::MESSAGE_503,
    ];
}

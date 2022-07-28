<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * phpunit.xml に定義されている DB に対して $ php artisan migrate:fresh を実行する。
     *
     * 今回 DB は テスト用の DB を準備してそこで実施する。
     *
     * テスト用の DB は sl_shop_db_test とする。
     */
    use RefreshDatabase;

    use CreatesApplication;
}

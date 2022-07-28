<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id')->comment('商品情報ID');
            $table->string('name')->length(10)->comment('商品名');
            $table->string('description')->length(50)->comment('商品説明');
            $table->integer('price')->default(0)->comment('金額');
            $table->unsignedInteger('brand_id')->comment('ブランド情報ID');
            $table->unsignedInteger('category_id')->comment('カテゴリー情報ID');
            $table->datetime('created_at')->comment('作成日');
            $table->datetime('updated_at')->comment('更新日');
            $table->datetime('deleted_at')->nullable()->comment('削除日');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}

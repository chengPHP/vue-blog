<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment("超链接名称");
            $table->string('title')->nullable()->comment("超链接标题");
            $table->string('url')->nullable()->comment("超链接url");
            $table->integer('orders')->nullable()->comment("排序");
            $table->integer('status')->nullable()->comment("状态 -1|软删除 0|禁用 1|启用");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}

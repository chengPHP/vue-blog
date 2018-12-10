<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题名称');
            $table->string('tags')->nullable()->comment('关键词');
            $table->string('descr')->nullable()->comment('文章简介');
//            $table->integer('category_id')->nullable()->comment('所属类别');
            $table->integer('admin_id')->nullable()->comment('作者');
            $table->text('art')->nullable()->comment('文章内容');
            $table->integer('read_num')->default(0)->comment('阅读量');
            $table->integer('status')->default(1)->comment('状态 -1|软删除 0|关闭 1|开启');
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
        Schema::dropIfExists('articles');
    }
}

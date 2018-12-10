<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('管理员姓名');
            $table->string('email')->unique()->comment('管理员邮箱');
            $table->string('phone')->unique()->comment('管理员手机号码');
            $table->string('password');
            $table->tinyInteger('status')->default('1')->comment('用户所属状态 -1|软删除 0|禁用 1|启用');
            $table->dateTime('last_login_time')->nullable()->comment('最后一次登录时间');
            $table->string('last_login_ip')->nullable()->comment('用户上一次登录IP地址');
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
        Schema::dropIfExists('admins');
    }
}

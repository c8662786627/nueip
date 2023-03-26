<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 將 '男' 轉換成 1，'女' 轉換成 0
        DB::table('account_info')->where('gender', '男')->update(['gender' => 1]);
        DB::table('account_info')->where('gender', '女')->update(['gender' => 0]);
        Schema::table('account_info', function (Blueprint $table) {
            //
            $table->integer('gender')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('account_info', function (Blueprint $table) {
            //
            $table->string('gender')->change();
        });
        // 將 1 轉換成 '男'，0 轉換成 '女'
        DB::table('account_info')->where('gender', '1')->update(['gender' => '男']);
        DB::table('account_info')->where('gender', '0')->update(['gender' => '女']);
    }
};

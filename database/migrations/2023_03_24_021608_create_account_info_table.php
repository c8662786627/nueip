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
        Schema::create('account_info', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('name');
            $table->string('gender');
            $table->date('birthday');
            $table->string('email');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('account_info');
    }
};

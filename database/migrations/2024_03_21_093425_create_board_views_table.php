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
        Schema::create('board_views2', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('board_type', ['event', 'notice', 'education']); // type 컬럼 추가
            $table->integer('board_id');
            $table->tinyInteger('is_banner')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_views');
    }
};

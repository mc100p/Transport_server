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
        Schema::create('personnel_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('clientName');
            $table->string('comment');
            $table->string('deliveryPersonnel');
            $table->integer('dpid');
            $table->integer('uid');
            $table->integer('ratings');
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
        Schema::dropIfExists('personnel_ratings');
    }
};

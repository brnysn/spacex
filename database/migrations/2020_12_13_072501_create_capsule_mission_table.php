<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsuleMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsule_mission', function (Blueprint $table) {
            $table->unsignedBigInteger('mission_id');
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->unsignedBigInteger('capsule_id');
            $table->foreign('capsule_id')->references('id')->on('capsules')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capsule_mission');
    }
}

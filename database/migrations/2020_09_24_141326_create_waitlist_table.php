<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waitlist', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('team_id')->nullable();

            // Foreign keys
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waitlist');
    }
}

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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('league_id');
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->timestamp('date');
            $table->integer('home_team_score');
            $table->integer('away_team_score');
            $table->enum('state',['did not start','playing now','game over']);
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->foreign('home_team_id')->references('id')->on('clubs');
            $table->foreign('away_team_id')->references('id')->on('clubs');
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
        Schema::dropIfExists('matches');
    }
};

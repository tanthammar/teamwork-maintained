<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeamworkSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\Config::get('teamwork.users_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('current_team_id')->nullable();
        });


        Schema::create(\Config::get('teamwork.teams_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable()->unique()->index()->after('id');
            $table->unsignedBigInteger('owner_id')->nullable()->index();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('photo_url')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create(\Config::get('teamwork.team_user_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('team_id')->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references(\Config::get('teamwork.user_foreign_key'))
                ->on(\Config::get('teamwork.users_table'))
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get('teamwork.teams_table'))
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create(\Config::get('teamwork.team_invites_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable()->unique()->index()->after('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->enum('type', ['invite', 'request']);
            $table->string('email');
            $table->string('accept_token');
            $table->string('deny_token');
            $table->timestamps();
            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get('teamwork.teams_table'))
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\Config::get('teamwork.users_table'), function (Blueprint $table) {
            $table->dropColumn('current_team_id');
        });

        Schema::table(\Config::get('teamwork.team_user_table'), function (Blueprint $table) {
            $table->dropForeign(\Config::get('teamwork.team_user_table') . '_user_id_foreign');
            $table->dropForeign(\Config::get('teamwork.team_user_table') . '_team_id_foreign');
        });

        Schema::drop(\Config::get('teamwork.team_user_table'));
        Schema::drop(\Config::get('teamwork.team_invites_table'));
        Schema::drop(\Config::get('teamwork.teams_table'));
    }
}

<?php

use Silber\Bouncer\Database\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBouncerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Models::table('abilities'), function (Blueprint $table) {
            $this->bouncerPrimaryKey($table);
            $table->string('name');
            $table->string('title')->nullable();
            $this->bouncerMorphId($table,'entity_id')->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('only_owned')->default(false);
            $table->json('options')->nullable();
            $table->integer('scope')->nullable()->index();
            $table->timestamps();
        });

        Schema::create(Models::table('roles'), function (Blueprint $table) {
            $this->bouncerPrimaryKey($table);
            $table->string('name');
            $table->string('title')->nullable();
            $table->integer('level')->unsigned()->nullable();
            $table->integer('scope')->nullable()->index();
            $table->timestamps();

            $table->unique(
                ['name', 'scope'],
                'roles_name_unique'
            );
        });

        Schema::create(Models::table('assigned_roles'), function (Blueprint $table) {
            $this->bouncerPrimaryKey($table);
            $this->bouncerMorphId($table,'role_id');
            $this->bouncerMorphId($table,'entity_id');
            $table->string('entity_type');
            $table->bigInteger('restricted_to_id')->unsigned()->nullable();
            $table->string('restricted_to_type')->nullable();
            $table->integer('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'assigned_roles_entity_index'
            );

            $table->foreign('role_id')
                ->references('id')->on(Models::table('roles'))
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create(Models::table('permissions'), function (Blueprint $table) {
            $this->bouncerPrimaryKey($table);
            $this->bouncerMorphId($table,'ability_id');
            $this->bouncerMorphId($table,'entity_id')->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('forbidden')->default(false);
            $table->integer('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'permissions_entity_index'
            );

            $table->foreign('ability_id')
                ->references('id')->on(Models::table('abilities'))
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Models::table('permissions'));
        Schema::drop(Models::table('assigned_roles'));
        Schema::drop(Models::table('roles'));
        Schema::drop(Models::table('abilities'));
    }

    protected function bouncerPrimaryKey(Blueprint $table)
    {
        return config('bouncer.use_uuid') ?
            $table->uuid('id')->primary() :
            $table->bigIncrements('id');
    }


    protected function bouncerMorphId(Blueprint $table, string $name)
    {
        return config('bouncer.use_uuid') ?
            $table->uuid($name) :
            $table->bigInteger($name)->unsigned();
    }
}

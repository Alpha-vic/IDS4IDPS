<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_relationship', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('object_id');
            $table->unsignedInteger('relationship_id');
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->foreign('subject_id', 'pr_p1_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('object_id', 'pr_p2_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('relationship_id', 'pr_r_id')->references('id')->on('relationships')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('person_relationship');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->char('sex', 1)->nullable();
            $table->decimal('height')->nullable();
            $table->string('blood_group', 3)->nullable();
            $table->string('photo', 2000)->nullable();
            $table->binary('left_thumb')->nullable();
            $table->binary('right_thumb')->nullable();
            $table->text('description')->nullable();
            $table->string('code', 32)->nullable();
            $table->unsignedInteger('lga_id')->nullable();
            $table->unsignedInteger('camp_id')->nullable();
            $table->unsignedTinyInteger('status');
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->unique('code', 'persons_code');
            $table->foreign('lga_id', 'persons_lga_id')->references('id')->on('lgas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('camp_id', 'persons_camp_id')->references('id')->on('camps')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('persons');
    }
}

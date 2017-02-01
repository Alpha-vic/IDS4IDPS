<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->char('sex',1);
            $table->decimal('height')->nullable();
            $table->decimal('blood_group')->nullable();
            $table->string('photo', 2000)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('description')->nullable();
            $table->string('code', 32);
            $table->unsignedInteger('lga_id');
            $table->unsignedInteger('camp_id');
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

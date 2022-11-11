<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseModuleQuizOptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // remove correct option from quiz table because we will use it in options table
        Schema::table('course_module_quiz', function (Blueprint $table) {
            $table->dropColumn('correct_option');
        });

        Schema::create('course_module_quiz_opts', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id');
            $table->string('option');
            $table->tinyInteger('is_correct')->default(0);
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
        Schema::dropIfExists('course_module_quiz_opts');
    }
}

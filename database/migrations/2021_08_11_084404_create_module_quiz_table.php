<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_module_quiz', function (Blueprint $table) {
            $table->id();
			$table->integer('course_id');
            $table->integer('module_id');
			$table->string('question');
			$table->enum('type', ['SINGLE_SELECT', 'MULTI_SELECT'])->default('SINGLE_SELECT');
			$table->string('correct_option');
			$table->string('option_a');
			$table->string('option_b');
			$table->string('option_c');
			$table->string('option_d');
			$table->integer('question_index');
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
        Schema::dropIfExists('course_module_quiz');
    }
}

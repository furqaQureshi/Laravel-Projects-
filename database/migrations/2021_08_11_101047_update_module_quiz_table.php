<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateModuleQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_module_quiz', function (Blueprint $table) {
            $table->dropColumn('option_a');
            $table->dropColumn('option_b');
            $table->dropColumn('option_c');
            $table->dropColumn('option_d');
			$table->integer('correct_option')->after('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

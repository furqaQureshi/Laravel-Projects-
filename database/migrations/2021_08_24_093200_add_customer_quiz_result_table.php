<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerQuizResultTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_quiz_result', function (Blueprint $table) {
			$table->id();
			$table->integer('user_id');
			$table->integer('module_id');
			$table->integer('quiz_id');
			$table->integer('total_questions');
			$table->integer('total_attempted');
			$table->integer('total_correct');
			$table->integer('result');
			$table->timestamps();
		});
		
		// add foreign key of result table in customer quiz answers table
		Schema::table('customer_quiz_answers', function (Blueprint $table) {
			$table->integer('result_id')->after('user_id');
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

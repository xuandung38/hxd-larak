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
		Schema::create('blog_categories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->text('description');
			$table->string('image');
			$table->string('slug')->unique()->nullable();
			$table->nestedSet();
			$table->softDeletes();
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
		Schema::dropIfExists('blog_categories');
	}
};

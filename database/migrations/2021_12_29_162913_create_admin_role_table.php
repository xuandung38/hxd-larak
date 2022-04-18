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
		Schema::create('admin_role', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('role_id');
			$table->unsignedBigInteger('admin_id');
			$table->timestamps();

			$table->foreign('role_id')->references('id')->on('roles');
			$table->foreign('admin_id')->references('id')->on('admins');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('admin_role');
	}
};

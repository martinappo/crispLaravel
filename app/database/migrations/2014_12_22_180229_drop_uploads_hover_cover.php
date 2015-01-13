<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUploadsHoverCover extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artworks', function($table)
		{
			$table->dropColumn('uploads');
			$table->dropColumn('hover');
			$table->dropColumn('cover');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artworks', function($table)
		{
			$table->string('uploads');
			$table->string('hover');
			$table->string('cover');
		});
	}

}

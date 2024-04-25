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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
			$table->decimal('temperature', 10);
			$table->tinyInteger('fan');
			$table->decimal('humidity', 10);
			$table->decimal('light_intensity', 10);
			$table->tinyInteger('lights');
			$table->tinyInteger('motion');
			$table->tinyInteger('buzzer');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
};

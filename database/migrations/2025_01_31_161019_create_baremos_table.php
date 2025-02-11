<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaremosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baremos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_escala_id')
                  ->nullable()
                  ->constrained('sub_escalas')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('p_c',30);
            $table->string('edad_meses',11);
            $table->string('puntos',11);
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
        Schema::dropIfExists('baremos');
    }
}

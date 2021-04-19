<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTypeProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages_type_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->nullable($value=true);
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
            $table->foreignId('type_procedure_id')->nullable($value=true);
            $table->foreign('type_procedure_id')->references('id')->on('type_procedures')->onDelete('cascade');
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
        Schema::dropIfExists('stages_type_procedures');
    }
}

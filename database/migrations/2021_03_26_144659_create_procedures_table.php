<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50)->nullable($value=true);
            $table->text('description')->nullable($value=true);
            $table->char('year', 4)->nullable($value=true);
            $table->string('status', 50)->nullable($value=true);
            $table->foreignId('department_id')->nullable($value=true);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreignId('type_procedure_id')->nullable($value=true);
            $table->foreign('type_procedure_id')->references('id')->on('type_procedures')->onDelete('set null');
            $table->foreignId('user_id')->nullable($value=true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('procedures');
    }
}

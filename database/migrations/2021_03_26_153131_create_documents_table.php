<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable($value=true);
            $table->string('file_name')->nullable($value=true);
            $table->string('file_path')->nullable($value=true);
            $table->string('file_path_delete')->nullable($value=true);
            $table->string('file_size')->nullable($value=true);
            $table->string('file_type')->nullable($value=true);
            $table->foreignId('procedure_id')->nullable($value=true);
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
            $table->foreignId('section_id')->nullable($value=true);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
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
        Schema::dropIfExists('documents');
    }
}

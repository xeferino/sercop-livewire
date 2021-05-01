<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsDateToDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->timestamp('date_draft')->nullable($value=true)->after('section_id');
            $table->timestamp('date_pending')->nullable($value=true)->after('date_draft');
            $table->timestamp('date_published')->nullable($value=true)->after('date_pending');
            $table->timestamp('date_completed')->nullable($value=true)->after('date_published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
}

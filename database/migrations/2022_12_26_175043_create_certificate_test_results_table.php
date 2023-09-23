<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->default(0)->constrained()->cascadeOnDelete();
            $table->float('setting',8,2);//float
            $table->float('instrument',8,2);//float
            $table->float('error',8,2);//float
            $table->enum('status', [1, 0])->default(1);//enum (1,0)
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('certificate_test_results');
    }
}

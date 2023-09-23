<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_no',20)->unique();
            $table->date('calibration_date',15);
            $table->date('next_calibration_date',15);
            $table->string('reference',255);
          
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('digital_signature',255);
            $table->longText('remark')->nullable();
            $table->longText('product_details')->comment('json prdt data');
            $table->longText('client_details')->comment('json client data');
            $table->enum('status', [1, 0])->default(1);
            $table->string('created_by')->nullable();
            $table->longText('updated_by')->nullable()->comment('json update admin_details data');
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
        Schema::dropIfExists('certificates');
    }
}

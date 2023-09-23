<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255);
            $table->string('contact_person_name', 255);
            $table->string('country_code', 15);
            $table->string('company_number', 15);
            $table->string('email', 255)->unique();
            $table->string('country', 255);
            $table->string('pin_code', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('GSTIN', 255)->unique();
            $table->text('address')->nullable();
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('Clients');
    }
}

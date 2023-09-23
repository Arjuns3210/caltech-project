<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Created By : Maaz Ansari
     * Created at : 08-aug-2022
     * Uses : To create new Table
     * 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name', 255);
            $table->string('nick_name', 255);
            $table->string('email', 255)->unique();
            $table->string('country_code',15);
            $table->string('phone', 15);
            $table->string('password');
            $table->text('address')->nullable();
            $table->foreignId('role_id')->default(0)->constrained()->cascadeOnDelete();
            $table->enum('status', [1, 0])->default(1);
            $table->enum('sms_notification', [1, 0])->default(1);
            $table->enum('email_notification', [1, 0])->default(1);
            $table->enum('whatsapp_notification', [1, 0])->default(1);
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
        Schema::dropIfExists('admins');
    }
}

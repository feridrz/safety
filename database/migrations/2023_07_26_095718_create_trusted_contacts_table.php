<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrustedContactsTable extends Migration
{
    public function up()
    {
        Schema::create('trusted_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('contact_name', 100)->nullable();;
            $table->string('contact_number', 20);
            $table->string('contact_email', 100)->nullable();;
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trusted_contacts');
    }
}

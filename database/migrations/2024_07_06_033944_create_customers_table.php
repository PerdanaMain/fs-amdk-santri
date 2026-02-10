<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id("customer_id");
            $table->unsignedBigInteger("user_id");
            $table->string("customer_name");
            $table->string("customer_owner");
            $table->string("customer_phone")->nullable();
            $table->string("customer_address")->nullable();
            $table->string("customer_description")->nullable();
            $table->string("customer_coordinate")->nullable();
            $table->string("customer_photo")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

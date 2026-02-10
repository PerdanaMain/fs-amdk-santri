<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id("visit_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("customer_id");
            $table->string("visit_description")->nullable();
            $table->text("visit_photo")->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('customer_id')->references('customer_id')->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

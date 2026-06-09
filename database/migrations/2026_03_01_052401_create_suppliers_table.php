<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('supplier_name');
            $table->string('supplier_owner')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_address')->nullable();
            $table->string('supplier_description')->nullable();
            $table->string('supplier_coordinate')->nullable();
            $table->string('supplier_photo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};

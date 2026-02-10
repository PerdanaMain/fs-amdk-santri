<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id("purchase_id");
            $table->unsignedBigInteger("stock_id");
            $table->unsignedBigInteger("status_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("finance_id")->nullable();
            $table->string("purchase_description");
            $table->integer("purchase_quantity");
            $table->integer("purchase_price");
            $table->integer("purchase_total");
            $table->string("purchase_reject_message")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
            $table->foreign('status_id')->references('status_id')->on('statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('finance_id')->references('finance_id')->on('finances')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

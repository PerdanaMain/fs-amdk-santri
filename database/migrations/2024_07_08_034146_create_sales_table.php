<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id("sale_id");
            $table->unsignedBigInteger("customer_id");
            $table->unsignedBigInteger("payment_id");
            $table->unsignedBigInteger("stock_id");
            $table->unsignedBigInteger("status_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("finance_id")->nullable();
            $table->integer("sale_quantity");
            $table->integer("sale_price");
            $table->integer("sale_total");
            $table->string("sale_description")->nullable();
            $table->string("sale_invoice")->nullable();
            $table->timestamp("sale_date")->nullable();
            $table->text("sale_reject_message")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("customer_id")->references("customer_id")->on("customers")->onDelete("cascade");
            $table->foreign("payment_id")->references("payment_id")->on("payments")->onDelete("cascade");
            $table->foreign("stock_id")->references("stock_id")->on("stocks")->onDelete("cascade");
            $table->foreign("status_id")->references("status_id")->on("statuses")->onDelete("cascade");
            $table->foreign("user_id")->references("user_id")->on("users")->onDelete("cascade");
            $table->foreign("finance_id")->references("finance_id")->on("finances")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

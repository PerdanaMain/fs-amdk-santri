<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id("shipment_id");
            $table->unsignedBigInteger("sale_id");
            $table->string("shipment_status");
            $table->timestamps();

            $table->foreign("sale_id")->references("sale_id")->on("sales");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
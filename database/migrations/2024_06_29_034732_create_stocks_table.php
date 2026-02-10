<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id("stock_id");
            $table->string("stock_name");
            $table->string("stock_photo");
            $table->integer("stock_quantity");
            $table->string("stock_satuan");
            $table->string("stock_description");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id("finance_id");
            $table->string("finance_code", 10)->unique();
            $table->string("finance_name", 50);
            $table->integer("finance_debet");
            $table->integer("finance_credit");
            $table->text("finance_description");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
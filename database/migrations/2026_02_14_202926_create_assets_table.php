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
        Schema::create('assets', function (Blueprint $table) {
            $table->id('asset_id');
            $table->string('asset_code');
            $table->string('asset_name');
            $table->date('purchase_date');
            $table->decimal('purchase_price', 15, 2);
            $table->integer('lifetime_years'); // Rumus life time asset (in years)
            $table->string('asset_photo')->nullable();
            $table->decimal('depreciation_per_month', 15, 2); // Nilai deviasi per bulan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};

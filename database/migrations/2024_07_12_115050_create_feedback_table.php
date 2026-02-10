<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id("feedback_id");
            $table->string("feedback_firstname");
            $table->string("feedback_lastname")->nullable();
            $table->string("feedback_email")->nullable();
            $table->string("feedback_phone")->nullable();
            $table->text("feedback_message")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};

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
        Schema::create('users', function (Blueprint $table) {
            $table->id("user_id");
            $table->unsignedBigInteger("role_id");
            $table->string('user_nik')->nullable();
            $table->string('user_nip')->nullable();;
            $table->string('user_name');
            $table->string('user_phone');
            $table->string('user_address');
            $table->string('user_photo')->nullable();
            $table->string('user_description')->nullable();
            $table->string('user_branch')->nullable();
            $table->string('email')->unique();
            $table->string("status")->default("active");
            $table->boolean("is_forgot")->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken("remember_token");
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('gender',['Male','Female']);
            $table->string('email')->unique();
            $table->string('phone',14)->unique();
            $table->string('city');
            $table->tinyText('address');
            $table->string('profile')->nullable();
            $table->string('card_ID')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('code',6);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};

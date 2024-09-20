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
        Schema::create('mailing_list_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mailing_list_id')->constrained()->cascadeOnDelete('cascade');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailing_list_user');
    }
};

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
        Schema::create('document_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->index()->nullable()->constrained('documents')->nullOnDelete();
            $table->foreignId('user_id')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->integer('last_viewed_version');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_users');
    }
};

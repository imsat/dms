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
        Schema::create('changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->index()->nullable()->constrained('documents')->nullOnDelete();
            $table->foreignId('user_id')->index()->nullable()->constrained('users')->nullOnDelete();
            $table->integer('version');
            $table->integer('last_viewed_version');
            $table->tinyInteger('status')->nullable()->comment('0= deleted, 1= added | 3= modified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changes');
    }
};

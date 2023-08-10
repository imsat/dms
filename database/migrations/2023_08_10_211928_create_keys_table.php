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
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('change_id')->index()->nullable()->constrained('changes')->nullOnDelete();
            $table->string('key')->comment('introduction, facts, summary, tag');
            $table->longText('content_before')->nullable();
            $table->longText('content_after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys');
    }
};

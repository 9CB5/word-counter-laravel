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
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->timestamps();
        });

        Schema::create('keyword_website', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Keyword::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Website::class)->constrained()->cascadeOnDelete();

            $table->integer('frequency');
            $table->integer('density');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyword_website');
        Schema::dropIfExists('keywords');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('source');
            $table->text('title')->unique();
            $table->text('content')->nullable();
            $table->string('author')->nullable();
            $table->string('category')->nullable();
            $table->timestamp('published_at');
            $table->text('url')->nullable();
            $table->timestamps();
            $table->foreign('category')->references('name')->on('categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

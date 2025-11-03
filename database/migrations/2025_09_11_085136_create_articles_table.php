<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // связь с users
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unsignedBigInteger('views')->default(0); // количество просмотров
            $table->timestamp('published_at')->nullable(); 
        });
    }

    public function down(): void {
        Schema::dropIfExists('articles');
    }
};

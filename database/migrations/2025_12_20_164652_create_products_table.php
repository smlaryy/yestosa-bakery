<?php

// database/migrations/xxxx_create_products_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->unsignedInteger('price_per_pcs')->nullable(); // rupiah
            $table->unsignedInteger('price_per_box')->nullable(); // rupiah

            $table->unsignedTinyInteger('min_preorder_days')->default(1); // 1 atau 2
            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->index(['category_id', 'is_available']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};

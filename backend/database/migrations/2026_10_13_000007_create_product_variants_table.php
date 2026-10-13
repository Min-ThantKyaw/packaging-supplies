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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku', 100);
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('thickness', 50)->nullable();
            $table->string('unit', 50)->nullable();
            $table->unsignedInteger('pack_size')->nullable();
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('pack_price', 12, 2)->default(0);
            $table->boolean('sell_by_unit')->default(true);
            $table->boolean('sell_by_pack')->default(false);
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->unique(['user_id', 'sku']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

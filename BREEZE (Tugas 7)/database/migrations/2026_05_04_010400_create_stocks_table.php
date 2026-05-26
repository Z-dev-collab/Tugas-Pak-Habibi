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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            // null = stok pusat, ada id = stok cabang
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->integer('qty')->default(0);

            $table->timestamps();

            $table->unique(['branch_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

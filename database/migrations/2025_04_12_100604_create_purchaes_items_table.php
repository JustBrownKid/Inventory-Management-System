<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //id, purchase_id (FK), product_id (FK), quantity, unit_price, timestamps

    public function up()
{
    Schema::create('purchase_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');
        $table->decimal('unit_price', 8, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};

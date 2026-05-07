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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('invoice_no')->unique();
        $table->date('date');
        $table->decimal('total', 15, 2)->default(0);
        $table->decimal('discount', 15, 2)->default(0);
        $table->decimal('grand_total', 15, 2)->default(0);
        $table->enum('payment_method', ['cash', 'transfer', 'qris'])->default('cash');
        $table->decimal('amount_paid', 15, 2)->default(0);
        $table->decimal('change', 15, 2)->default(0);
        $table->enum('status', ['completed', 'cancelled'])->default('completed');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

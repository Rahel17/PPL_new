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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('hari_tanggal');
            $table->foreignId('categories_id')->constrained('categories')->onDelete('cascade');
            $table->string('bidang');
            $table->decimal('nominal', 15, 0)->default(0); 
            $table->decimal('total', 15, 0)->default(0);
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->binary('bukti_transaksi')->nullable();
            $table->binary('spj')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

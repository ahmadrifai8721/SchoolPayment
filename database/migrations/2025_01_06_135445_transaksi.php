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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->string("tanggal");
            $table->foreignId("methode_pembayaran_id")->constrained("methode_pembayarans")->cascadeOnDelete();
            $table->foreignId("tagihan_id")->constrained("tagihans")->cascadeOnDelete();
            $table->integer("fee");
            $table->integer("total");
            $table->string("snapToken")->nullable();
            $table->string("order_id")->nullable();
            $table->string("transaction_id")->nullable();
            $table->string("status");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

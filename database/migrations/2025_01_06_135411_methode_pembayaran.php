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
        Schema::create('methode_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("type")->default("offline");
            $table->boolean("percent")->default(false);
            $table->integer("biayaTransaksi")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('methode_pembayarans');
    }
};

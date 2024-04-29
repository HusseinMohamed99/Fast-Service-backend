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
        Schema::create('information_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('users');
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->decimal('price_from', 8, 2)->nullable();
            $table->decimal('price_to', 8, 2)->nullable();
            $table->time('working_hours_from')->nullable();
            $table->time('working_hours_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_workers');
    }
};

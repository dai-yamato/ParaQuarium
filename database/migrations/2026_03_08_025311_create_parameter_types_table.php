<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameter_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // null = default system type
            $table->string('name'); // e.g., '水温', 'pH', 'KH'
            $table->string('unit')->nullable(); // e.g., '℃', 'ppm', '°dH'
            $table->string('icon')->nullable(); // e.g., 'thermometer'
            $table->integer('sort_order')->default(0);
            $table->boolean('is_default')->default(false); // Used to identify system defaults
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameter_types');
    }
};

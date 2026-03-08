<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_record_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('water_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('parameter_type_id')->constrained()->onDelete('cascade');
            $table->float('value')->nullable(); // nullable if they leave it empty, but usually it should be provided. Allow null to handle empty submissions.
            $table->timestamps();
            
            // A record can only have one value per parameter type
            $table->unique(['water_record_id', 'parameter_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_record_values');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('property_type', [
                'apartment', 'villa', 'plot', 'office',
                'pg_hostel', 'farm_land', 'home', 'other',
            ]);
            $table->string('city');
            $table->string('state')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->text('description');
            $table->string('contact_name')->nullable();
            $table->string('contact_phone');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['city', 'property_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_requirements');
    }
};

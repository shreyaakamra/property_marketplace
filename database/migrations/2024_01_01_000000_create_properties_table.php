<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('listing_type', ['rent', 'sale']);
            $table->enum('property_type', [
                'apartment', 'villa', 'plot', 'office',
                'pg_hostel', 'farm_land', 'home', 'other',
            ]);
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('locality')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->unsignedTinyInteger('bhk')->nullable();
            $table->unsignedInteger('area_sqft')->nullable();
            $table->enum('furnishing', ['unfurnished', 'semi', 'full'])->nullable();
            $table->json('amenities')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone');
            $table->boolean('is_verified_owner')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['city', 'property_type', 'listing_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

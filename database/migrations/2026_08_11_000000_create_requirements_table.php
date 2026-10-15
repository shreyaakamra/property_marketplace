<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Columns are named to mirror `properties` 1:1 (listing_type, city,
     * locality, bhk, area_sqft, price, furnishing) so the matching query
     * in Requirement::matchingProperties() is a straight column comparison
     * with no name-translation layer.
     */
    public function up(): void
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();

            // Who posted it (nullable so agents can log a walk-in/phone lead too)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Requester contact info
            $table->string('requester_name');
            $table->string('requester_phone')->nullable();
            $table->string('requester_email')->nullable();

            // Core matching criteria — mirrors properties table columns
            $table->enum('listing_type', ['sale', 'rent'])->default('rent');
            $table->string('bhk')->nullable();        // e.g. "1", "2", "3+" — treated as a minimum
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->unsignedBigInteger('min_price')->nullable();
            $table->unsignedBigInteger('max_price')->nullable();
            $table->unsignedInteger('min_area_sqft')->nullable();
            $table->unsignedInteger('max_area_sqft')->nullable();
            $table->string('furnishing')->nullable();  // e.g. "furnished", "semi", "unfurnished" — leave blank for "any"
            $table->json('preferred_amenities')->nullable();

            $table->text('notes')->nullable();
            $table->enum('status', ['open', 'matched', 'closed'])->default('open');

            $table->timestamps();

            $table->index(['listing_type', 'city', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
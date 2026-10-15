<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'title' => 'Furnished 2BHK near Vijay Nagar, Indore',
                'description' => 'Well-lit 2BHK on the 3rd floor, gated society, close to Vijay Nagar Square. Bachelors welcome.',
                'listing_type' => 'rent',
                'property_type' => 'apartment',
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'locality' => 'Vijay Nagar',
                'price' => 24000,
                'bhk' => 2,
                'area_sqft' => 1050,
                'furnishing' => 'full',
                'amenities' => ['parking', 'lift', 'security'],
                'contact_name' => 'Ramesh Patil',
                'contact_phone' => '9800000001',
                'is_verified_owner' => true,
            ],
            [
                'title' => 'Semi-furnished 3BHK, Mahalaxmi Nagar',
                'description' => 'Spacious 3BHK, family preferred, near main market.',
                'listing_type' => 'rent',
                'property_type' => 'apartment',
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'locality' => 'Mahalaxmi Nagar',
                'price' => 32000,
                'bhk' => 3,
                'area_sqft' => 1450,
                'furnishing' => 'semi',
                'amenities' => ['garden', 'clubhouse'],
                'contact_name' => 'Sunita Rao',
                'contact_phone' => '9800000002',
                'is_verified_owner' => true,
            ],
            [
                'title' => '1BHK for Rent, Koramangala, Bangalore',
                'description' => 'Compact 1BHK, ideal for a working professional, close to metro.',
                'listing_type' => 'rent',
                'property_type' => 'apartment',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'locality' => 'Koramangala',
                'price' => 21000,
                'bhk' => 1,
                'area_sqft' => 620,
                'furnishing' => 'semi',
                'amenities' => ['lift'],
                'contact_name' => 'Arjun Mehta',
                'contact_phone' => '9800000003',
                'is_verified_owner' => false,
            ],
            [
                'title' => 'Residential Plot, Super Corridor, Indore',
                'description' => '1200 sqft east-facing plot, TNCP approved, road touch.',
                'listing_type' => 'sale',
                'property_type' => 'plot',
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'locality' => 'Super Corridor',
                'price' => 4200000,
                'bhk' => null,
                'area_sqft' => 1200,
                'furnishing' => null,
                'amenities' => [],
                'contact_name' => 'Deepak Soni',
                'contact_phone' => '9800000004',
                'is_verified_owner' => true,
            ],
            [
                'title' => 'PG for Working Women, Bandra West, Mumbai',
                'description' => 'Single/double sharing, meals included, walking distance to station.',
                'listing_type' => 'rent',
                'property_type' => 'pg_hostel',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'locality' => 'Bandra West',
                'price' => 14000,
                'bhk' => null,
                'area_sqft' => null,
                'furnishing' => 'full',
                'amenities' => ['meals', 'wifi', 'laundry'],
                'contact_name' => 'Neha Kulkarni',
                'contact_phone' => '9800000005',
                'is_verified_owner' => true,
            ],
            [
                'title' => 'Independent 4BHK Villa, Whitefield, Bangalore',
                'description' => 'Duplex villa in a gated community, private garden, 2 covered parking.',
                'listing_type' => 'sale',
                'property_type' => 'villa',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'locality' => 'Whitefield',
                'price' => 18500000,
                'bhk' => 4,
                'area_sqft' => 3200,
                'furnishing' => 'semi',
                'amenities' => ['garden', 'clubhouse', 'gym', 'parking'],
                'contact_name' => 'Vikram Shah',
                'contact_phone' => '9800000006',
                'is_verified_owner' => true,
            ],
        ];

        foreach ($samples as $sample) {
            Property::create($sample);
        }
    }
}

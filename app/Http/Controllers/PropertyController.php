<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::query()
            ->where('is_active', true)
            ->city($request->query('city'))
            ->type($request->query('property_type'))
            ->listingType($request->query('listing_type'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'query' => '',
            'filters' => [],
        ]);
    }

    public function show(Property $property)
    {
        return view('properties.show', ['property' => $property]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'listing_type' => 'required|in:rent,sale',
            'property_type' => 'required|in:apartment,villa,plot,office,pg_hostel,farm_land,home,other',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'locality' => 'nullable|string|max:150',
            'price' => 'nullable|numeric|min:0',
            'bhk' => 'nullable|integer|min:1|max:10',
            'area_sqft' => 'nullable|integer|min:1',
            'furnishing' => 'nullable|in:unfurnished,semi,full',
            'contact_name' => 'nullable|string|max:100',
            'contact_phone' => 'required|string|max:20',
        ]);

        $property = Property::create($validated);

        return redirect()
            ->route('properties.show', $property)
            ->with('status', "Listed! Your registry code is {$property->code}.");
    }
}

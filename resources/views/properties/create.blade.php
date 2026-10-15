@extends('layouts.app')

@section('title', 'Post to Shared Spaces')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-1">Post to Shared Spaces</h1>
    <p class="text-sm text-gray-500 mb-6">Tell us what your client is looking for — we'll match it against live listings.</p>

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('shared-spaces.store') }}" class="space-y-6">
        @csrf

        <fieldset class="space-y-4">
            <legend class="font-medium text-gray-800 mb-2">Requester</legend>

            <div>
                <label for="requester_name" class="block text-sm font-medium text-gray-700">Name *</label>
                <input type="text" name="requester_name" id="requester_name" value="{{ old('requester_name') }}"
                       required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="requester_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="requester_phone" id="requester_phone" value="{{ old('requester_phone') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="requester_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="requester_email" id="requester_email" value="{{ old('requester_email') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
        </fieldset>

        <fieldset class="space-y-4">
            <legend class="font-medium text-gray-800 mb-2">What they're looking for</legend>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose *</label>
                    <select name="purpose" id="purpose" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Select...</option>
                        <option value="sale" @selected(old('purpose') === 'sale')>Buy</option>
                        <option value="rent" @selected(old('purpose') === 'rent')>Rent</option>
                    </select>
                </div>
                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700">Property Type</label>
                    <input type="text" name="property_type" id="property_type" value="{{ old('property_type') }}"
                           placeholder="e.g. apartment, villa, plot"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700">Area / Locality</label>
                    <input type="text" name="area" id="area" value="{{ old('area') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700">Min Budget</label>
                    <input type="number" name="min_price" id="min_price" value="{{ old('min_price') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700">Max Budget</label>
                    <input type="number" name="max_price" id="max_price" value="{{ old('max_price') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="min_bedrooms" class="block text-sm font-medium text-gray-700">Min Bedrooms</label>
                    <input type="number" name="min_bedrooms" id="min_bedrooms" value="{{ old('min_bedrooms') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="min_bathrooms" class="block text-sm font-medium text-gray-700">Min Bathrooms</label>
                    <input type="number" name="min_bathrooms" id="min_bathrooms" value="{{ old('min_bathrooms') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="min_area_sqft" class="block text-sm font-medium text-gray-700">Min Area (sqft)</label>
                    <input type="number" name="min_area_sqft" id="min_area_sqft" value="{{ old('min_area_sqft') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="max_area_sqft" class="block text-sm font-medium text-gray-700">Max Area (sqft)</label>
                    <input type="number" name="max_area_sqft" id="max_area_sqft" value="{{ old('max_area_sqft') }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
            </div>
        </fieldset>

        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                Post Requirement
            </button>
        </div>
    </form>
</div>
@endsection

```php
@extends('layouts.app')

@section('title', $property->title . ' — Registry.Home')

@section('content')
<section class="wrap" style="padding-top:40px; max-width:720px;">
    <span class="code-tab">{{ $property->code }}</span>
    <h1 style="font-family:var(--font-display); color:var(--ink); margin:12px 0;">{{ $property->title }}</h1>
    <div class="meta" style="margin-bottom:20px;">
        {{ $property->locality ? $property->locality . ', ' : '' }}{{ $property->city }}, {{ $property->state }}
        @if ($property->bhk) &middot; {{ $property->bhk }} BHK @endif
        @if ($property->area_sqft) &middot; {{ number_format($property->area_sqft) }} sqft @endif
        @if ($property->furnishing) &middot; {{ ucfirst($property->furnishing) }} furnished @endif
    </div>

    <div class="price" style="font-size:1.4rem; margin-bottom:24px;">
        @if ($property->price)
            &#8377;{{ number_format($property->price) }}
            <span>{{ $property->listing_type === 'rent' ? '/ month' : 'total' }}</span>
        @else
            Price on request
        @endif
    </div>

    @if ($property->description)
        <p style="color:var(--charcoal); line-height:1.7; margin-bottom:28px;">{{ $property->description }}</p>
    @endif

    @if (!empty($property->amenities))
        <div class="filters-echo" style="margin-bottom:28px;">
            @foreach ($property->amenities as $amenity)
                <span class="chip">{{ $amenity }}</span>
            @endforeach
        </div>
    @endif

    <a class="btn btn-brass"
       href="https://wa.me/91{{ $property->contact_phone }}?text={{ urlencode('Hi, I found your listing ' . $property->code . ' on Registry.Home — is it still available?') }}"
       target="_blank" rel="noopener">
        Contact {{ $property->contact_name ?: 'owner' }} on WhatsApp
    </a>
</section>
@endsection

@php
    $fallbackImages = [
        'apartment'  => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500',
        'villa'      => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500',
        'home'       => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500',
        'pg_hostel'  => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500',
        'plot'       => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=500',
        'farm_land'  => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=500',
        'office'     => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500',
    ];
    // [CONFIRM FIELD] swap $property->photo_url in once that column exists
    $photo = $property->photo_url ?? $fallbackImages[$property->property_type] ?? $fallbackImages['apartment'];
@endphp

<a href="{{ route('properties.show', $property) }}" class="listing-card-link">
    <div class="card property-card-photo" style="background-image: linear-gradient(180deg, rgba(10,25,41,0.05) 0%, rgba(10,25,41,0.92) 68%), url('{{ $photo }}');">

        @if ($property->is_verified_owner)
            <span class="card-badge">Direct Owner</span>
        @endif

        <span class="code-tab">{{ $property->code }}</span>

        <div class="property-card-body">
            <h3>{{ $property->title }}</h3>
            <div class="meta">
                {{ $property->locality ? $property->locality . ', ' : '' }}{{ $property->city }}
                @if ($property->bhk) &middot; {{ $property->bhk }} BHK @endif
                @if ($property->area_sqft) &middot; {{ number_format($property->area_sqft) }} sqft @endif
            </div>
            <div class="price">
                @if ($property->price)
                    &#8377;{{ number_format($property->price) }}
                    <span>{{ $property->listing_type === 'rent' ? '/ month' : 'total' }}</span>
                @else
                    Price on request
                @endif
            </div>
        </div>
    </div>
</a>
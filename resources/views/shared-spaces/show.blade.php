@extends('layouts.app')

@section('title', $requirement->requester_name . "'s Requirement — Registry.Home")

@section('content')
<section class="wrap" style="padding-top:40px; max-width:720px;">
    <a href="{{ route('shared-spaces.index') }}" style="color:var(--charcoal); text-decoration:none; font-size:0.9rem;">&larr; Shared Spaces</a>

    @if (session('status'))
        <div class="chip" style="display:block; margin:20px 0; padding:12px 16px;">
            {{ session('status') }}
        </div>
    @endif

    <span class="code-tab" style="margin-top:20px; display:inline-block;">{{ ucfirst($requirement->status) }}</span>
    <h1 style="font-family:var(--font-display); color:var(--ink); margin:12px 0;">{{ $requirement->requester_name }}</h1>
    <div class="meta" style="margin-bottom:20px;">
        {{ $requirement->requester_phone }}
        @if ($requirement->requester_phone && $requirement->requester_email) &middot; @endif
        {{ $requirement->requester_email }}
    </div>

    <div class="price" style="font-size:1.2rem; margin-bottom:8px;">
        {{ $requirement->listing_type === 'rent' ? 'Looking to rent' : 'Looking to buy' }}
        @if ($requirement->bhk) &middot; {{ $requirement->bhk }} BHK+ @endif
    </div>
    <div class="meta" style="margin-bottom:24px;">
        {{ trim(($requirement->locality ?? '') . ($requirement->locality && $requirement->city ? ', ' : '') . ($requirement->city ?? '')) ?: 'Any location' }}
        @if ($requirement->min_price || $requirement->max_price)
            &middot; &#8377;{{ $requirement->min_price ? number_format($requirement->min_price) : 'Any' }}
            &ndash; &#8377;{{ $requirement->max_price ? number_format($requirement->max_price) : 'Any' }}
        @endif
        @if ($requirement->min_area_sqft || $requirement->max_area_sqft)
            &middot; {{ $requirement->min_area_sqft ?? 'Any' }}&ndash;{{ $requirement->max_area_sqft ?? 'Any' }} sqft
        @endif
        @if ($requirement->furnishing) &middot; {{ ucfirst($requirement->furnishing) }} @endif
    </div>

    @if ($requirement->notes)
        <p style="color:var(--charcoal); line-height:1.7; margin-bottom:28px;">{{ $requirement->notes }}</p>
    @endif

    <h2 style="font-family:var(--font-display); color:var(--ink); font-size:1.1rem; margin:32px 0 16px;">
        Matching Properties ({{ $matches->total() }})
    </h2>

    @if ($requirement->city)
        <a href="/properties/{{ \Illuminate\Support\Str::slug($requirement->city) }}/home" class="chip" style="margin-bottom:16px; display:inline-block;">
            Browse all listings in {{ $requirement->city }}
        </a>
    @endif

    <div class="requirements-list">
        @forelse ($matches as $property)
            <a href="/property/{{ $property->id }}" style="display:block; border-bottom:1px solid var(--hairline, #e5e0d8); padding:16px 0; text-decoration:none;">
                <span class="code-tab" style="font-size:0.75rem;">{{ $property->code }}</span>
                <div style="font-family:var(--font-display); color:var(--ink); margin:6px 0;">{{ $property->title }}</div>
                <div class="meta">
                    {{ $property->locality ? $property->locality . ', ' : '' }}{{ $property->city }}
                    @if ($property->bhk) &middot; {{ $property->bhk }} BHK @endif
                    @if ($property->price) &middot; &#8377;{{ number_format($property->price) }} @endif
                </div>
            </a>
        @empty
            <p style="color:var(--charcoal); padding:24px 0;">No matching properties yet — we'll keep checking as new listings come in.</p>
        @endforelse
    </div>

    <div style="margin-top:24px;">
        {{ $matches->links() }}
    </div>
</section>
@endsection
{{-- Mirrors the shape of partials.property-card — swap in your real card
     markup/classes here once you share that file; this is a best-guess
     match based on the chip/meta/grid patterns used elsewhere on the site. --}}
<a href="{{ route('shared-spaces.show', $requirement) }}" class="card" style="text-decoration:none; display:block;">
    <div style="display:flex; align-items:baseline; justify-content:space-between;">
        <span style="font-family:var(--font-display); color:var(--ink); font-size:1.05rem;">
            {{ $requirement->requester_name }}
        </span>
        <span class="chip" style="{{ ($requirement->match_count ?? 0) > 0 ? '' : 'opacity:0.6;' }}">
            {{ $requirement->match_count ?? 0 }} {{ Str::plural('match', $requirement->match_count ?? 0) }}
        </span>
    </div>
    <div class="meta" style="margin-top:6px;">
        {{ $requirement->listing_type === 'rent' ? 'Rent' : 'Buy' }}
        @if ($requirement->bhk) &middot; {{ $requirement->bhk }} BHK @endif
        @if ($requirement->locality || $requirement->city)
            &middot; {{ trim(($requirement->locality ?? '') . ($requirement->locality && $requirement->city ? ', ' : '') . ($requirement->city ?? '')) }}
        @endif
    </div>
    @if ($requirement->min_price || $requirement->max_price)
        <div class="price" style="font-size:1rem; margin-top:6px;">
            &#8377;{{ $requirement->min_price ? number_format($requirement->min_price) : 'Any' }}
            &ndash; &#8377;{{ $requirement->max_price ? number_format($requirement->max_price) : 'Any' }}
        </div>
    @endif
    <div class="meta" style="margin-top:6px; font-size:0.85rem;">
        {{ $requirement->created_at->diffForHumans() }}
    </div>
</a>
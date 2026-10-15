@extends('layouts.app')

@section('title', 'Shared Spaces — Registry.Home')

@section('content')
<section class="wrap" style="padding-top:40px;">

    <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:4px;">
        <form action="{{ route('shared-spaces.index') }}" method="GET" style="margin-bottom:4px; flex:1;">
            <div class="search-row" style="max-width:640px;">
                <input type="text" name="q" placeholder="Search requirements..." value="{{ $query ?? '' }}">
                <button type="submit" class="btn btn-brass">Search</button>
            </div>
            {{-- Structured filters ride along with the text search so a single submit covers both --}}
            <input type="hidden" name="listing_type" value="{{ $filters['listing_type'] ?? '' }}">
            <input type="hidden" name="city" value="{{ $filters['city'] ?? '' }}">
            <input type="hidden" name="bhk" value="{{ $filters['bhk'] ?? '' }}">
        </form>
        <a class="btn btn-brass" href="{{ route('shared-spaces.create') }}" style="white-space:nowrap; margin-left:16px;">+ Post a Requirement</a>
    </div>

    @if (session('status'))
        <div class="chip" style="display:block; margin:16px 0; padding:12px 16px;">
            {{ session('status') }}
        </div>
    @endif

    @if (!empty($filters) && array_filter($filters))
        <div class="filters-echo">
            @foreach ($filters as $key => $value)
                @if ($value !== null && $value !== '')
                    <span class="chip">{{ str_replace('_', ' ', $key) }}: {{ $value }}</span>
                @endif
            @endforeach
            <a href="{{ route('shared-spaces.index') }}" class="chip">Clear all</a>
        </div>
    @endif

    <h2 class="section-title">
        {{ $requirements->total() }} {{ Str::plural('requirement', $requirements->total()) }}
    </h2>

    @if ($requirements->isEmpty())
        <div class="empty-state">
            No requirements match that yet. Try loosening the filters.
        </div>
    @else
        <div class="grid">
            @foreach ($requirements as $requirement)
                @include('partials.requirement-card', ['requirement' => $requirement])
            @endforeach
        </div>

        <div class="pagination">
            {{ $requirements->links() }}
        </div>
    @endif
</section>
@endsection
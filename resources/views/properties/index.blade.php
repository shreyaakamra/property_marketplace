
@extends('layouts.app')

@section('title', 'Search results — Registry.Home')

@section('content')
<section class="wrap" style="padding-top:40px;">

    <form action="{{ route('search') }}" method="GET" style="margin-bottom:4px;">
        <div class="search-row" style="max-width:640px;">
            <input type="text" name="q" placeholder="Search again..." value="{{ $query ?? '' }}">
            <button type="submit" class="btn btn-brass">Search</button>
        </div>
    </form>

    @if (!empty($filters))
        <div class="filters-echo">
            @foreach ($filters as $key => $value)
                @if ($value !== null && $value !== '')
                    <span class="chip">{{ str_replace('_', ' ', $key) }}: {{ $value }}</span>
                @endif
            @endforeach
        </div>
    @endif

    <h2 class="section-title">
        {{ $properties->total() }} {{ Str::plural('result', $properties->total()) }}
    </h2>

    @if ($properties->isEmpty())
        <div class="empty-state">
            Nothing matches that yet. Try loosening the budget or dropping the locality.
        </div>
    @else
        <div class="grid">
            @foreach ($properties as $property)
                @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>

        <div class="pagination">
            {{ $properties->links() }}
        </div>
    @endif
</section>
@endsection

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequirementRequest;
use App\Models\Requirement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequirementController extends Controller
{
    /**
     * Listing page: all open requirements, with optional filters and a
     * live match count per row so agents can eyeball demand at a glance.
     */
    public function index(): View
    {
        $query = request('q');

        $filters = [
            'listing_type' => request('listing_type'),
            'city'         => request('city'),
            'bhk'          => request('bhk'),
        ];

        $requirements = Requirement::query()
            ->when($query, fn ($q) => $q->where(function ($q2) use ($query) {
                $q2->where('requester_name', 'like', "%{$query}%")
                    ->orWhere('locality', 'like', "%{$query}%")
                    ->orWhere('notes', 'like', "%{$query}%");
            }))
            ->when($filters['city'], fn ($q) => $q->where('city', $filters['city']))
            ->when($filters['listing_type'], fn ($q) => $q->where('listing_type', $filters['listing_type']))
            ->when($filters['bhk'], fn ($q) => $q->where('bhk', $filters['bhk']))
            ->when(request('status'), fn ($q) => $q->where('status', request('status')), fn ($q) => $q->where('status', '!=', 'closed'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Attach match counts without N+1'ing too badly for a first pass.
        $requirements->getCollection()->transform(function (Requirement $requirement) {
            $requirement->match_count = $requirement->matchCount();
            return $requirement;
        });

        return view('shared-spaces.index', compact('requirements', 'query', 'filters'));
    }

    public function create(): View
    {
        return view('shared-spaces.create');
    }

    public function store(StoreRequirementRequest $request): RedirectResponse
    {
        $requirement = Requirement::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('shared-spaces.show', $requirement)
            ->with('status', 'Requirement posted. We found ' . $requirement->matchCount() . ' matching propert' . ($requirement->matchCount() === 1 ? 'y' : 'ies') . ' already.');
    }

    /**
     * Show a single requirement with its live matching properties.
     */
    public function show(Requirement $requirement): View
    {
        $matches = $requirement->matchingProperties()->latest()->paginate(12);

        return view('shared-spaces.show', compact('requirement', 'matches'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rating::with(['alternatif', 'kriteria']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('alternatif', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('kriteria', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        // Filter by alternatif
        if ($request->filled('alternatif_id')) {
            $query->where('id_alternatif', $request->alternatif_id);
        }

        // Filter by kriteria
        if ($request->filled('kriteria_id')) {
            $query->where('id_kriteria', $request->kriteria_id);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['nilai', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $ratings = $query->paginate(10)->withQueryString();
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();

        return view('rating.index', compact('ratings', 'alternatif', 'kriteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();

        return view('rating.create', compact('alternatif', 'kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_alternatif' => ['required', 'exists:alternatif,id'],
            'id_kriteria' => ['required', 'exists:kriteria,id'],
            'nilai' => ['required', 'numeric', 'min:0'],
        ]);

        // Check if rating already exists for this alternatif and kriteria
        $existingRating = Rating::where('id_alternatif', $validated['id_alternatif'])
            ->where('id_kriteria', $validated['id_kriteria'])
            ->first();

        if ($existingRating) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Rating already exists for this alternatif and kriteria.');
        }

        Rating::create($validated);

        return redirect()->route('rating.index')
            ->with('success', 'Rating created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        $rating->load(['alternatif', 'kriteria']);

        return view('rating.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();

        return view('rating.edit', compact('rating', 'alternatif', 'kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $validated = $request->validate([
            'id_alternatif' => ['required', 'exists:alternatif,id'],
            'id_kriteria' => ['required', 'exists:kriteria,id'],
            'nilai' => ['required', 'numeric', 'min:0'],
        ]);

        // Check if rating already exists for this alternatif and kriteria (excluding current rating)
        $existingRating = Rating::where('id_alternatif', $validated['id_alternatif'])
            ->where('id_kriteria', $validated['id_kriteria'])
            ->where('id', '!=', $rating->id)
            ->first();

        if ($existingRating) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Rating already exists for this alternatif and kriteria.');
        }

        $rating->update($validated);

        return redirect()->route('rating.index')
            ->with('success', 'Rating updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return redirect()->route('rating.index')
            ->with('success', 'Rating deleted successfully.');
    }

    /**
     * Show the form for batch creating ratings for an alternatif.
     */
    public function createBatch()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::all();

        return view('rating.create-batch', compact('alternatif', 'kriteria'));
    }

    /**
     * Store batch ratings for an alternatif.
     */
    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'id_alternatif' => ['required', 'exists:alternatif,id'],
            'nilai' => ['required', 'array'],
            'nilai.*' => ['required', 'numeric', 'min:0'],
        ]);

        $alternatifId = $validated['id_alternatif'];
        $nilaiValues = $validated['nilai'];
        $successCount = 0;
        $errorCount = 0;

        foreach ($nilaiValues as $kriteriaId => $nilai) {
            // Check if rating already exists for this alternatif and kriteria
            $existingRating = Rating::where('id_alternatif', $alternatifId)
                ->where('id_kriteria', $kriteriaId)
                ->first();

            if ($existingRating) {
                // Update existing rating
                $existingRating->update(['nilai' => $nilai]);
                $successCount++;
            } else {
                // Create new rating
                Rating::create([
                    'id_alternatif' => $alternatifId,
                    'id_kriteria' => $kriteriaId,
                    'nilai' => $nilai
                ]);
                $successCount++;
            }
        }

        return redirect()->route('rating.index')
            ->with('success', $successCount . ' ratings created/updated successfully.');
    }
}

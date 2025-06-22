<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kriteria::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('atribut', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['nama', 'bobot', 'atribut', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $kriteria = $query->paginate(10)->withQueryString();

        // Calculate total bobot
        $totalBobot = Kriteria::sum('bobot');

        return view('kriteria.index', compact('kriteria', 'totalBobot'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'bobot' => ['required', 'numeric', 'min:0', 'max:1'],
            'atribut' => ['required', 'string', Rule::in(['benefit', 'cost'])],
        ]);

        // Calculate the sum of existing weights
        $existingWeightsSum = Kriteria::sum('bobot');

        // Check if adding the new weight would exceed 1
        if ($existingWeightsSum + $validated['bobot'] > 1) {
            return back()
                ->withInput()
                ->withErrors(['bobot' => 'Total bobot tidak bisa lebih dari 1. Total saat ini: ' . $existingWeightsSum]);
        }

        Kriteria::create($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriterium)
    {
        return view('kriteria.show', compact('kriterium'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriterium)
    {
        return view('kriteria.edit', compact('kriterium'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriterium)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'bobot' => ['required', 'numeric', 'min:0', 'max:1'],
            'atribut' => ['required', 'string', Rule::in(['benefit', 'cost'])],
        ]);

        // Calculate the sum of existing weights excluding the current criterion
        $existingWeightsSum = Kriteria::where('id', '!=', $kriterium->id)->sum('bobot');

        // Check if updating the weight would exceed 1
        if ($existingWeightsSum + $validated['bobot'] > 1) {
            return back()
                ->withInput()
                ->withErrors(['bobot' => 'Total bobot tidak bisa lebih dari 1. Total saat ini: ' . $existingWeightsSum]);
        }

        $kriterium->update($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria deleted successfully.');
    }
}

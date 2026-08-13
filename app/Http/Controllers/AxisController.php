<?php

namespace App\Http\Controllers;

use App\Http\Requests\AxisCreateRequest;
use Illuminate\Http\Request;
use App\Models\Axis;


class AxisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $axes = Axis::withCount('themes')
            ->get()
            ->map(function ($axis) {
                // Cálculo dinámico del porcentaje de avance
                $axis->progress_percentage = $axis->calculateProgressPercentage();
                return $axis;
            });

        return view('pages.admin.ejes', compact('axes'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AxisCreateRequest $request)
    {
        $axe = Axis::create($request->validated());
        return redirect()->route('ejes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

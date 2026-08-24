<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Axis;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $tematicas = Theme::with(['axis'])->withCount('indicators')->orderBy('axis_id')->get();
        $ejes = Axis::orderBy('axis_number')->get(); // para el <select> del modal

        return view('pages.admin.tematicas', compact('tematicas', 'ejes'));
    }

    public function store(StoreThemeRequest $request)
    {
        Theme::create($request->validated());

        return redirect()->route('tematicas.index')->with('success', 'Temática creada correctamente.');
    }

    public function update(UpdateThemeRequest $request, Theme $tematica)
    {
        $tematica->update($request->validated());

        return redirect()->route('tematicas.index')->with('success', 'Temática actualizada correctamente.');
    }

   
}

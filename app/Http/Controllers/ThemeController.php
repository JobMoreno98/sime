<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Axis;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function show($id)
    {
        $theme = Theme::findOrFail($id);
        return view('pages.admin.tematicas.show', compact('theme'));
    }

    public function destroy(Theme $tematica): RedirectResponse
    {
        if ($tematica->indicators()->exists()) {
            return redirect()->back()->with('error', 'No se puede eliminar la temática "' . $tematica->name . '" porque tiene indicadores asociados. Reasigna o elimina los indicadores primero.');
        }

        $tematica->delete();

        return redirect()->route('tematicas.index')->with('success', 'Temática eliminada correctamente.');
    }
}

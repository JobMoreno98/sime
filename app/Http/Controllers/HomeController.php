<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Axis;
use App\Models\Indicator;

class HomeController extends Controller
{
    // Método para la página de Inicio / Principal
    public function index()
    {
        // Consultamos solo lo necesario para el público
        //$totalIndicators = Indicator::count(); // Ej. 53
        //$axes = Axis::with('themes')->get();   // Ejes con sus temáticas
        //$axes = Axis::all();
        $axes = Axis::with('themes')->get();
        //$recentProgress = ProgressRecord::latest()->take(5)->get(); // Últimos 5 avances

        return view('pages.inicio', compact('axes'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Importar Controller base
use Illuminate\Http\Request;
use Illuminate\View\View; // Importar View

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard de administración.
     */
    public function index(): View
    {
        // De momento solo devuelve la vista
        // Más adelante podemos pasarle datos (ej. número de clientes, proyectos)
        return view('admin.dashboard');
    }
}

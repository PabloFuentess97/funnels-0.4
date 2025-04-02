<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importar Auth

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y si es administrador
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            // Si no es admin, redirigir o abortar
            // Opción 1: Redirigir al dashboard
            // return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
            
            // Opción 2: Abortar con error 403 (Forbidden)
            abort(403, 'Acceso no autorizado.'); 
        }

        // Si es admin, permitir que la solicitud continúe
        return $next($request);
    }
}

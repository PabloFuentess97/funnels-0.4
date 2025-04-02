<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Link;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        // Si el usuario no tiene compañía asociada, mostrar panel vacío
        if (!$company) {
            return view('dashboard', [
                'stats' => [
                    'total_projects' => 0,
                    'total_links' => 0,
                    'active_links' => 0,
                ],
                'dates' => [],
                'clicks' => [],
                'hasCompany' => false
            ]);
        }
        
        // Obtener estadísticas generales
        $stats = [
            'total_projects' => Project::where('company_id', $company->id)->where('is_active', true)->count(),
            'total_links' => Link::whereHas('project', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })->count(),
            'active_links' => Link::whereHas('project', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })->where('is_active', true)->count(),
        ];

        // Datos para el gráfico de clics por día (últimos 7 días)
        $clicksData = Click::whereHas('link.project', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as clicks')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Preparar datos para el gráfico
        $dates = [];
        $clicks = [];
        
        // Llenar con 0s los días sin clics
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $clickCount = $clicksData->firstWhere('date', $date)?->clicks ?? 0;
            
            $dates[] = Carbon::parse($date)->format('M d');
            $clicks[] = $clickCount;
        }

        return view('dashboard', [
            'stats' => $stats,
            'dates' => $dates,
            'clicks' => $clicks,
            'hasCompany' => true
        ]);
    }
}

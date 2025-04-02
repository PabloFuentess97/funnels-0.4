<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Round;
use App\Models\Click;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->company->projects()
            ->withCount(['rounds', 'links'])
            ->withCount('clicks')
            ->paginate(10);

        return view('reports.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load([
            'rounds' => function($query) {
                $query->withCount('clicks')->orderByDesc('round_number');
            },
            'links' => function($query) {
                $query->withCount('clicks')->orderBy('position');
            }
        ]);

        // Obtener el total de clicks del proyecto
        $totalClicks = $project->clicks()->count();

        return view('reports.show', compact('project', 'totalClicks'));
    }

    public function downloadPdf(Project $project)
    {
        $project->load([
            'rounds' => function($query) {
                $query->withCount('clicks')->orderByDesc('round_number');
            },
            'links' => function($query) {
                $query->withCount('clicks')->orderBy('position');
            }
        ]);

        // Obtener el total de clicks del proyecto
        $totalClicks = $project->clicks()->count();

        $pdf = PDF::loadView('reports.pdf', compact('project', 'totalClicks'));
        return $pdf->download("reporte-{$project->slug}.pdf");
    }
}

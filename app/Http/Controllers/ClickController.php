<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Click;
use App\Models\Link;

class ClickController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clicks = Click::with('link')->paginate(10);
        return view('clicks.index', compact('clicks'));
    }

    /**
     * Register a new click for a link.
     */
    public function register($slug)
    {
        $link = Link::whereHas('project', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->where('is_active', true)->first();

        if (!$link) {
            abort(404);
        }

        // Verificar si el link ha alcanzado su límite de clicks
        if ($link->current_clicks >= $link->click_limit) {
            $link->is_active = false;
            $link->save();
            
            // Verificar si hay más links activos en el proyecto
            $activeLinks = $link->project->links()->where('is_active', true)->count();
            
            if ($activeLinks === 0) {
                // Si no hay más links activos, completar la ronda actual
                $currentRound = $link->project->rounds()->where('is_active', true)->first();
                if ($currentRound) {
                    $currentRound->is_completed = true;
                    $currentRound->is_active = false;
                    $currentRound->save();

                    // Si el proyecto está configurado para rondas infinitas, crear una nueva ronda
                    if ($link->project->infinite_rounds) {
                        $newRoundNumber = $currentRound->round_number + 1;
                        $link->project->rounds()->create([
                            'round_number' => $newRoundNumber,
                            'is_active' => true
                        ]);

                        // Reactivar todos los links
                        $link->project->links()->update([
                            'is_active' => true,
                            'current_clicks' => 0
                        ]);
                    }
                }
            }

            return redirect()->away($link->url);
        }

        // Registrar el click
        $click = new Click([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        $click->save();

        // Incrementar el contador de clicks
        $link->increment('current_clicks');

        return redirect()->away($link->url);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clicks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Click $click)
    {
        return view('clicks.show', compact('click'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Click $click)
    {
        return view('clicks.edit', compact('click'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Click $click)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Click $click)
    {
        $click->delete();
        return redirect()->route('clicks.index')->with('success', 'Click eliminado correctamente');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = auth()->user()->company->projects()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects',
            'is_active' => 'boolean',
            'infinite_rounds' => 'boolean',
            'fallback_url' => 'nullable|url'
        ]);

        $validated['company_id'] = auth()->user()->company_id;
        $validated['is_active'] = $request->has('is_active');
        $validated['infinite_rounds'] = $request->has('infinite_rounds');

        $project = Project::create($validated);
        $project->slug = Str::slug($request->name) . '-' . Str::random(6);
        $project->save();

        // Crear la primera ronda
        $project->rounds()->create([
            'round_number' => 1,
            'is_active' => true
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        // Cargar las rondas paginadas
        $rounds = $project->rounds()
            ->orderByDesc('round_number')
            ->paginate(5);

        // Cargar los links con todos sus clics
        $project->load(['links' => function($query) {
            $query->orderBy('position');
        }, 'currentRound']);

        return view('projects.show', compact('project', 'rounds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . $project->id,
            'is_active' => 'boolean',
            'infinite_rounds' => 'boolean',
            'fallback_url' => 'nullable|url'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['infinite_rounds'] = $request->has('infinite_rounds');

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado correctamente');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Project;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $links = $project->links()->with('project')->paginate(10);
        
        return view('links.index', compact('links', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorize('create', [Link::class, $project]);

        return view('links.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('create', [Link::class, $project]);

        $validated = $request->validate([
            'url' => 'required|url',
            'click_limit' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'responsible' => 'nullable|string|max:255'
        ]);

        // Verificar que el proyecto pertenece a la empresa del usuario
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $position = $project->links()->max('position') + 1;
        $validated['position'] = $position;
        $validated['project_id'] = $project->id;
        $validated['is_active'] = $request->has('is_active');

        $link = new Link($validated);
        $link->save();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Link creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Link $link)
    {
        $this->authorize('view', $link);
        $link->load('clicks');
        return view('links.show', compact('link', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Link $link)
    {
        $this->authorize('update', $link);

        return view('links.edit', compact('project', 'link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Link $link)
    {
        $this->authorize('update', $link);

        $validated = $request->validate([
            'url' => 'required|url',
            'click_limit' => 'required|integer|min:1',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'responsible' => 'nullable|string|max:255'
        ]);

        // Verificar que el proyecto pertenece a la empresa del usuario
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        // Manejar el checkbox is_active
        $validated['is_active'] = $request->has('is_active');

        $link->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Link actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Link $link)
    {
        $this->authorize('delete', $link);

        $link->delete();
        
        return redirect()->route('projects.show', $project)
            ->with('success', 'Link eliminado correctamente');
    }

    /**
     * Update the positions of multiple links.
     */
    public function updatePositions(Request $request, Project $project)
    {
        $this->authorize('update', [Link::class, $project]);

        $positions = $request->input('positions');
        
        foreach ($positions as $index => $linkId) {
            Link::where('id', $linkId)->update(['position' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Reset the click count for a specific link.
     */
    public function resetClicks(Project $project, Link $link)
    {
        $this->authorize('update', $link);

        // Verificar que el proyecto pertenece a la empresa del usuario
        if ($project->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        // Reiniciar los clicks del link
        $link->clicks()->delete();
        $link->current_clicks = 0;
        $link->save();

        return redirect()->back()
            ->with('success', 'Clicks reiniciados correctamente');
    }
}

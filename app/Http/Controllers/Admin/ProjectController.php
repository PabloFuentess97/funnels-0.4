<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project): View
    {
        // Cargar los enlaces asociados al proyecto
        $project->load('links'); 
        
        // Pasar el proyecto (con sus enlaces) a la vista
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'is_active' no necesita validación explícita aquí, 
            // ya que manejaremos su presencia/ausencia.
        ]);

        $project->name = $validatedData['name'];
        $project->is_active = $request->has('is_active'); // True si el checkbox está marcado, false si no.
        
        $project->save();

        // Redirigir de vuelta a la vista de la compañía
        return redirect()->route('admin.companies.show', $project->company_id)
                         ->with('success', 'Project details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}

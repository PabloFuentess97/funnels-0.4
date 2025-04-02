<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = Company::with('owner')->latest()->paginate(15);
        
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $users = User::whereNull('company_id')->orderBy('name')->pluck('name', 'id'); // Obtener usuarios sin compañía para asignar como propietarios
        return view('admin.companies.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name', // Nombre requerido, único en la tabla companies
            'owner_id' => 'nullable|exists:users,id|unique:companies,owner_id', // Opcional, debe existir en users y ser único como owner
        ]);

        // Crear la compañía
        $company = Company::create([
            'name' => $validatedData['name'],
            'owner_id' => $validatedData['owner_id'] ?? null, // Asignar owner_id si se proporcionó
        ]);

        // Si se asignó un propietario, actualizar el company_id del usuario
        if ($company->owner_id) {
            $owner = User::find($company->owner_id);
            if ($owner) {
                $owner->company_id = $company->id;
                $owner->save();
            }
        }

        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): View
    {
        // Cargar la compañía con sus proyectos y propietario
        $company->load('projects', 'owner');

        // Contar proyectos activos e inactivos (asumiendo campo 'is_active' booleano)
        $activeProjectsCount = $company->projects->where('is_active', true)->count();
        $inactiveProjectsCount = $company->projects->where('is_active', false)->count();
        $totalProjectsCount = $company->projects->count();

        // Pasar los datos a la vista
        return view('admin.companies.show', compact(
            'company',
            'activeProjectsCount',
            'inactiveProjectsCount',
            'totalProjectsCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company): View // Route Model Binding y tipo de retorno
    {
        // Obtener usuarios sin compañía O el propietario actual de esta compañía
        $users = User::whereNull('company_id')
                     ->orWhere('id', $company->owner_id)
                     ->orderBy('name')
                     ->pluck('name', 'id');
                     
        return view('admin.companies.edit', compact('company', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company): \Illuminate\Http\RedirectResponse // Route Model Binding
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id, // Único, ignorando el registro actual
            'owner_id' => 'nullable|exists:users,id|unique:companies,owner_id,' . $company->id . ',id,owner_id,' . ($request->input('owner_id') ?? 'NULL'), // Único owner, ignorando el actual si no cambia
        ]);

        $oldOwnerId = $company->owner_id; // Guardar ID del propietario anterior
        $newOwnerId = $validatedData['owner_id'] ?? null; // Obtener nuevo ID del propietario (o null)

        // Actualizar los datos de la compañía
        $company->name = $validatedData['name'];
        $company->owner_id = $newOwnerId;
        $company->save();

        // --- Lógica para actualizar propietarios --- 
        // Solo si el propietario ha cambiado
        if ($oldOwnerId !== $newOwnerId) {
            // 1. Desasignar compañía del propietario anterior (si existía)
            if ($oldOwnerId) {
                $oldOwner = User::find($oldOwnerId);
                if ($oldOwner && $oldOwner->company_id === $company->id) { // Doble check por seguridad
                    $oldOwner->company_id = null;
                    $oldOwner->save();
                }
            }
            // 2. Asignar compañía al nuevo propietario (si se seleccionó uno nuevo)
            if ($newOwnerId) {
                $newOwner = User::find($newOwnerId);
                if ($newOwner) {
                    $newOwner->company_id = $company->id;
                    $newOwner->save();
                }
            }
        }
        // --- Fin lógica propietarios ---

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

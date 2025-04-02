<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

class CompanySettingsController extends Controller
{
    public function edit()
    {
        $company = auth()->user()->company;
        return view('settings.company', compact('company'));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->company;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
        ]);

        // Manejar el logo si se ha subido
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            // Eliminar el logo anterior si existe
            if ($company->logo_path) {
                Storage::delete($company->logo_path);
            }

            // Guardar el nuevo logo
            $path = $request->file('logo')->store('company-logos', 'public');
            $validated['logo_path'] = $path;
        }

        $company->update($validated);

        return back()->with('success', 'Información de la compañía actualizada correctamente.');
    }

    public function removeLogo()
    {
        $company = auth()->user()->company;
        
        if ($company->logo_path) {
            Storage::delete($company->logo_path);
            $company->update(['logo_path' => null]);
        }

        return back()->with('success', 'Logo eliminado correctamente.');
    }
}

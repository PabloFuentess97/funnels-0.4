<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['company.subscription.plan']);

        return view('profile.edit', [
            'user' => $user,
            'company' => $user->company,
            'subscription' => $user->company?->subscription,
            'plan' => $user->company?->subscription?->plan,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     * Nota: La lógica estaba implícita antes, la separamos conceptualmente en la vista.
     * La validación la hará Breeze/Fortify si se usa su ruta, o podemos añadirla aquí.
     * Por simplicidad de Breeze, podríamos dejar que el formulario apunte a la ruta existente
     * de actualización de contraseña si existe, o replicar la lógica aquí.
     * Vamos a añadir la lógica aquí para mantenerlo autocontenido en este controlador.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Update the company's information.
     */
    public function updateCompany(CompanyUpdateRequest $request): RedirectResponse
    {
        $company = $request->user()->company;

        if (!$request->user()->isCompanyOwner()) {
            abort(403, 'Unauthorized action.');
        }

        $company->fill($request->validated());
        $company->save();

        return Redirect::route('profile.edit')->with('status', 'company-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

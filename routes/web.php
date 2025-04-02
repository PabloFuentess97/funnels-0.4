<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\ReportController; // Agregado
use App\Http\Controllers\NotificationController; // Agregado
use App\Http\Controllers\CompanySettingsController; // Agregado
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas de proyectos
    Route::resource('projects', ProjectController::class);
    
    // Rutas de links anidadas dentro de proyectos
    Route::resource('projects.links', LinkController::class)->except(['index', 'show']);
    Route::post('projects/{project}/links/update-positions', [LinkController::class, 'updatePositions'])
        ->name('projects.links.update-positions');
    Route::put('projects/{project}/links/{link}/reset-clicks', [LinkController::class, 'resetClicks'])
        ->name('projects.links.reset-clicks');

    // Rutas de reportes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{project}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{project}/pdf', [ReportController::class, 'downloadPdf'])->name('reports.download-pdf');

    // Rutas de notificaciones
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Rutas de configuración de la compañía
    Route::get('/settings/company', [CompanySettingsController::class, 'edit'])->name('settings.company.edit');
    Route::put('/settings/company', [CompanySettingsController::class, 'update'])->name('settings.company.update');
    Route::delete('/settings/company/logo', [CompanySettingsController::class, 'removeLogo'])->name('settings.company.remove-logo');

    Route::resource('rounds', RoundController::class)->only(['store', 'update', 'destroy']);

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::patch('/profile/company', [ProfileController::class, 'updateCompany'])->name('profile.updateCompany');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Ruta pública para redirecciones
Route::get('/f/{slug}', [RedirectController::class, 'handle'])->name('funnel.redirect');

// Rutas de Administración (protegidas por middleware 'auth' y 'admin')
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard de Administración
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestión de Compañías (Clientes)
    Route::resource('companies', AdminCompanyController::class);
    Route::resource('projects', AdminProjectController::class)->except(['index', 'create', 'store']); // Por ahora, solo edit/update desde la vista company
    Route::resource('links', AdminLinkController::class)->only(['edit', 'update', 'destroy']); // Solo estas acciones por ahora
    // Otras rutas de admin si las hubiera...
});

require __DIR__.'/auth.php';

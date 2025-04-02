<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website_url',
        'logo_path',
        'description',
        'primary_color',
        'secondary_color',
        'social_links',
        'timezone',
        'address',
        'phone',
        'contact_email',
        'settings',
        'owner_id'
    ];

    protected $casts = [
        'social_links' => 'array',
        'settings' => 'array'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function subscription()
    {
        // Asumimos que una compañía solo tiene una suscripción activa a la vez
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    public function subscriptions()
    {
        // Para obtener el historial de suscripciones
        return $this->hasMany(Subscription::class);
    }

    public function plan()
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'company_id', 'id', 'id', 'plan_id')
            ->where('subscriptions.status', 'active');
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            return Storage::url($this->logo_path);
        }
        
        // Logo por defecto si no hay uno subido
        return asset('images/default-company-logo.png');
    }

    public function getSocialLinksAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setSocialLinksAttribute($value)
    {
        $this->attributes['social_links'] = json_encode($value);
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value, true) ?? [
            'notifications_enabled' => true,
            'default_click_limit' => 100,
            'auto_round_creation' => false,
            'show_analytics' => true
        ];
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }
}

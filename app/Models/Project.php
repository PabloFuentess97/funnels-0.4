<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Company;
use App\Models\Link;
use App\Models\Round;
use App\Models\Click;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'is_active',
        'infinite_rounds',
        'fallback_url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'infinite_rounds' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function currentRound()
    {
        return $this->hasOne(Round::class)->where('is_active', true);
    }

    public function clicks()
    {
        return $this->hasManyThrough(Click::class, Link::class);
    }
}

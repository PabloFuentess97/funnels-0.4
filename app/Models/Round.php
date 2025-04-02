<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;
use App\Models\Click;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'round_number',
        'is_active',
        'is_completed'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_completed' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
}

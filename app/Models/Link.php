<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;
use App\Models\Click;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'url',
        'click_limit',
        'current_clicks',
        'position',
        'is_active',
        'responsible'
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

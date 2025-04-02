<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use App\Models\Company;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'price', 'project_limit', 'link_limit', 'user_limit'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function companies()
    {
        return $this->hasManyThrough(Company::class, Subscription::class);
    }
}

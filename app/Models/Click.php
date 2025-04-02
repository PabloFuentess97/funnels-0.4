<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Link;
use App\Models\Round;

class Click extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'round_id',
        'ip_address',
        'user_agent'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}

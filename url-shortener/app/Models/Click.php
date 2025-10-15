<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_id',
        'clicked_at',
        'referer',
        'user_agent',
        'ip_hash',
        'country',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}



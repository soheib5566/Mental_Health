<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class dailymood extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'mood',
        'datetime',
        'user_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_mood')->as('user_mood')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testscore extends Model
{
    use HasFactory;

    protected $fillable = [
        'totalscores',
        'phyicalscores',
        'mentalscores',
        'date',
        'user_id',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

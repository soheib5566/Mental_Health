<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'code',
        'expires_at',
        'DOB',
        'gender',
        'image',
        'phone',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $guarded = [
    //     'name',
    //     'email',
    //     'password',
    //     'phone',
    //     'is_admin',
    // ];

    public function tasks(): HasMany
    {
        return $this->hasMany(task::class);
    }

    public function testscores(): HasMany
    {
        return $this->hasMany(Testscore::class);
    }

    public function dailymoods(): BelongsToMany
    {
        return $this->belongsToMany(dailymood::class, 'user_mood')->as('user_mood')->withTimestamps();
    }

    public function generete_code()
    {
        $this->code = rand(1000, 9999);
        $this->expires_at = now()->addMinutes(5);
        $this->save();
    }

    public function reset_code()
    {
        $this->code = null;
        $this->expires_at = null;
        $this->save();
    }
}

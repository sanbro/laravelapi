<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];
    /**
     * Summary of getHashedIdAttribute
     * @return string
     */
    public function getHashedIdAttribute()
    {
        return base64_encode($this->id); // Simple obfuscation
    }

    // Ensure `hashed_id` is included in the response
    protected $appends = ['hashed_id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Summary of projects
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Project, User>
     */
    public function projects(): BelongsToMany {
        return $this->belongsToMany(Project::class);
    }
    /**
     * Summary of timesheets
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Timesheet, User>
     */
    public function timesheets(): HasMany {
        return $this->hasMany(Timesheet::class);
    }
}

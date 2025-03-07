<?php

namespace App\Models;

use App\Traits\AuditorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use HasFactory,AuditorTrait;
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = ['name', 'status','created_by','updated_by','deleted_by'];
    /**
     * Summary of users
     * @return BelongsToMany<User, Project>
     */
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
    /**
     * Summary of timesheets
     * @return HasMany<Timesheet, Project>
     */
    public function timesheets(): HasMany {
        return $this->hasMany(Timesheet::class);
    }
    /**
     * Summary of attributes
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<AttributeValue, Project>
     */
    public function attributes()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }
}

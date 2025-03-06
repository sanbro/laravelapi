<?php

namespace App\Models;

use App\Traits\AuditorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Timesheet extends Model
{
    use HasFactory,AuditorTrait;

    protected $fillable = ['task_name', 'date', 'hours', 'user_id', 'project_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }
}

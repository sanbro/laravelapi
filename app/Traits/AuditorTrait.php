<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * Auditor Trait
 */
trait AuditorTrait
{
    use SoftDeletes;

    /**
     * Handle Model Events
     */
    public static function boot()
    {
        parent::boot();
        // Event while saving
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = Auth::check() ? Auth::id() : null;
            }
            if (defined('static::CREATED_BY') && Schema::hasColumn($model->getTable(), static::CREATED_BY)) {
                $model->{static::CREATED_BY} = Auth::check() ? Auth::id() : null;
            }
        });

        // Event while updating
        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = Auth::check() ? Auth::id() : null;
            }
            if (defined('static::UPDATED_BY') && Schema::hasColumn($model->getTable(), static::UPDATED_BY)) {
                $model->{static::UPDATED_BY} = Auth::check() ? Auth::id() : null;
            }
        });
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getDeletedAtColumn()} = $time;

        if ($this->timestamps && !is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;
            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        // Update deleted by
        if (Schema::hasColumn($this->getTable(), 'deleted_by')) {
            $columns['deleted_by'] = Auth::check() ? Auth::id() : null;
        }
        if (defined('static::DELETED_BY') && Schema::hasColumn($this->getTable(), static::DELETED_BY)) {
            $columns[static::DELETED_BY] = Auth::check() ? Auth::id() : null;
        }

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));

        $this->fireModelEvent('trashed', false);
    }
}

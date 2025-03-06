<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
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
    static::creating(function ($table) {
      if (Schema::hasColumn($table->table, 'created_by')) {
        $table->created_by = auth()->user() ? auth()->user()->id : null;
      }
      if (defined('static::CREATED_BY') && Schema::hasColumn($table->table, static::CREATED_BY)) {
        $table->{static::CREATED_BY} = auth()->user() ? auth()->user()->id : null;
      }
    });

    // Event while updating
    static::updating(function ($table) {
      if (Schema::hasColumn($table->table, 'updated_by')) {
        $table->updated_by = auth()->user() ? auth()->user()->id : null;
      }

      if (defined('static::UPDATED_BY') && Schema::hasColumn($table->table, static::UPDATED_BY)) {
        $table->{static::UPDATED_BY} = auth()->user() ? auth()->user()->id : null;
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
    if (Schema::hasColumn($this->table, 'deleted_by')) {
      $columns['deleted_by'] = auth()->user() ? auth()->user()->id : null;
    }
    if (defined('static::DELETED_BY') && Schema::hasColumn($this->table, static::DELETED_BY)) {
      $columns[static::DELETED_BY] = auth()->user() ? auth()->user()->id : null;
    }

    // Update deleted flag
    // if (Schema::hasColumn($this->table, 'isDeleted')) {
    //   $columns['isDeleted'] = 'Y';
    // }

    // if (Schema::hasColumn($this->table, 'chrDelete')) {
    //   $columns['chrDelete'] = 'Y';
    // }

    $query->update($columns);

    $this->syncOriginalAttributes(array_keys($columns));

    $this->fireModelEvent('trashed', false);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = ['name', 'type'];
    /**
     * Summary of values
     * @return HasMany<AttributeValue, Attribute>
     */
    public function values(): HasMany {
        return $this->hasMany(AttributeValue::class);
    }
}

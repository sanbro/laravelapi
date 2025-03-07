<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'attribute_id', 'entity_id', 'value',
    ];
    /**
     * Summary of attribute
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Attribute, AttributeValue>
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}

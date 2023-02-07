<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Equipment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * @var string $table
     */
    protected $table = 'equipments';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'type_id',
        'serial'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */

    public function toSearchableArray()

    {
        return [
            'serial' => $this->serial,
        ];

    }
}

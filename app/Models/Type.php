<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Type extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @var string $table
     */
    protected $table = 'types';


    /**
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'title',
        'mask',
    ];


    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */

    public function toSearchableArray()

    {
        return [
            'title' => $this->title,
            'mask' => $this->mask
        ];

    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'gi_id',
        'name',
    ];


    public function chars()
    {
        return $this->belongsToMany(Char::class);
    }
}

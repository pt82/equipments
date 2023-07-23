<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'url',
        'type',
        'name_ru'
    ];


    public function members()
    {
        return $this->belongsToMany(Member::class)->withPivot('rel', 'tir');
    }


}

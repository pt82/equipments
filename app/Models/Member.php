<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'power',
        'name_ru'
    ];

    protected $casts = [
        'name_ru' => 'string'
    ];

    protected $appends = [
        'name_ru'
    ];

    public function getNameRuAttribute()
    {
        return $this->name;
    }

    public function chars()
    {
        return $this->belongsToMany(Char::class)->withPivot('rel', 'tir');
    }
}

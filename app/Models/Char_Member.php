<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char_Member extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'char_member';
    protected $fillable = [
        'member_id',
        'char_id',
        'rel',
        'tir',
        'ability_data',
        'rarity'
    ];

    protected $casts = [
        'ability_data' => 'array'
    ];
}

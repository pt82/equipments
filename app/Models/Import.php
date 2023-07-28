<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    const STATUS_START = 'start';
    const STATUS_PROCESS = 'process';
    const STATUS_FINISH = 'finish';
    const STATUS_ERROR = 'error';


    protected $fillable = [
        'gi_id',
        'status',
    ];


    public function saveStatus ($status)
    {
        $this->status = $status;
        $this->save();
    }
}

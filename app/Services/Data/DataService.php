<?php


namespace App\Services\Data;


use App\Models\Char_Member;
use App\Services\Chars\CharsService;

class DataService
{

    public function deleteAll()
    {
        Char_Member::query()->truncate();
    }
}

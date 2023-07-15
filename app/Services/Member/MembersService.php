<?php


namespace App\Services\Member;


use App\Models\Member;

class MembersService
{
    public function loadModel($id)
    {

    }


    public function loadModels($params = null)
    {
        return Member::query()->get();
    }


}

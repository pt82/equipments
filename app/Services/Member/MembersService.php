<?php


namespace App\Services\Member;


use App\Models\Member;
use App\Services\Client\ApiSwgohHelp;
use Exception;

class MembersService
{
    public function loadModel($id)
    {

    }


    public function loadModels($params = null)
    {
        return Member::query()->get();
    }


    public function updateListMembersFromSW($data)
    {
        try {
            foreach ($data as $player)
            {
                $model = Member::query()->where('external_id', $player['ally_code'])->first();
                if (!$model)
                {
                    $model = new Member();
                }
                $model->name = $player['player_name'];
                $model->external_id = $player['ally_code'];
                $model->power = $player['galactic_power'];
                $model->save();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMembersFromSW()
    {
        try {
            $client = new ApiSwgohHelp();
            return $client->fetchMembers();

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getInfoMember($memberId)
    {
        $client = new ApiSwgohHelp();
        return $client->fetchInfoMember($memberId);
    }
}

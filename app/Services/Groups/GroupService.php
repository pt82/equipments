<?php


namespace App\Services\Groups;


use App\Models\Group;

class GroupService
{
    /**
     * @var int
     */
    private $guildId;

    public function __construct($guildId = 52313) {
        $this->guildId = $guildId;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function  getAll()
    {
        return Group::query()->where('gi_id', $this->guildId)->get();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function create($request)
    {
        $model = new Group();
        $model->name = $request->name;
        return $model->save();
    }
}

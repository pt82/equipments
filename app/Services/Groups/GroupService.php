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
        return Group::query()->where('gi_id', $this->guildId)->with('chars')->get();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function create($request)
    {
        $model = new Group();
        $model->name = $request->name;
        $model->gi_id = $this->guildId;
        if ($model->save()) {
            $model->chars()->sync($request->ids);
            return true;
        }
        return false;
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function delete(Group $group)
    {
        $group->chars()->detach();
        return $group->delete();
    }
}

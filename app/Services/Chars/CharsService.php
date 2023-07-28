<?php


namespace App\Services\Chars;


use App\Models\Char;
use App\Models\Member;
use App\Services\Client\ApiSwgohHelp;
use Exception;

class CharsService
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function getCharsFromSW()
    {
        try {
            $client = new ApiSwgohHelp();
            $response = $client->fetchChars();

            return $client->getResponseBody($response);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getShipsFromSW()
    {
        try {
            $client = new ApiSwgohHelp();
            $response = $client->fetchShips();

            return $client->getResponseBody($response);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     * @throws Exception
     */
    public function updateListCharsFromSW($data, $type)
    {
        try {
            foreach ($data as $char) {
                $model = Char::query()->where('external_id', $char['base_id'])->first();
                if (!$model) {
                    $model = new Char();
                }
                $model->name = $char['name'];
                $model->image = $char['image'];
                $model->external_id = $char['base_id'];
                $model->url = $char['url'];
                $model->type = $type;
                $model->name_ru = $char['name_ru'] ?? '';
                $model->save();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getListChars()
    {
        try {
            return Char::query()->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     * @return array
     * @throws Exception
     */
    public function searchChars($data)
    {
        try {
            $result = [];
            $rel = $data['rel'] ?? "";
            $ids = $data['ids'];
            $membersIds =  Member::query()
                 ->when(!empty($rel), function ($query) use ($data)  {
                     return $query->whereHas('chars', function ($query) use ($data) {
                         $query->whereIn('char_id', $data['ids']);
                         $query->where('rel', '>', $data['rel']);
                     });
                 })
                 ->when(empty($rel), function ($query)  use ($ids) {
                     return $query->whereHas('chars', function ($query) use ($ids) {
                         $query->whereIn('char_id', $ids);
                     });
                 })
                ->get();
            foreach ($membersIds as $member)
            {
                if (!empty($rel))
                {
                    $chars = $member->chars()->whereIn('char_id', $data['ids'])->where('rel', '>' , $data['rel'])->get();
                }
                if (empty($rel))
                {
                    $chars = $member->chars()->whereIn('char_id', $data['ids'])->get();
                }
                $result[] = [
                    'id' => $member->id,
                    'name' => $member->name,
                    'external_id' => $member->external_id,
                    'chars' => $chars
                ];
            }
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchMembers($data)
    {
        try {
            $result = [];
            $rel = $data['rel'] ?? "";
            $ids = $data['ids'];
            $charsIds =  Char::query()
                ->when(!empty($rel), function ($query) use ($data)  {
                    return $query->whereHas('members', function ($query) use ($data) {
                        $query->whereIn('member_id', $data['ids']);
                        $query->where('rel', '>', $data['rel']);
                    });
                })
                ->when(empty($rel), function ($query)  use ($ids) {
                    return $query->whereHas('members', function ($query) use ($ids) {
                        $query->whereIn('member_id', $ids);
                    });
                })
                ->get();
            foreach ($charsIds as $char)
            {
                if (!empty($rel))
                {
                    $members = $char->members()->whereIn('member_id', $data['ids'])->where('rel', '>' , $data['rel'])->get();
                }
                if (empty($rel))
                {
                    $members = $char->members()->whereIn('char_id', $data['ids'])->get();
                }
                $result[] = [
                    'id' => $char->id,
                    'name' => $char->name,
                    'external_id' => $char->external_id,
                    'members' => $members
                ];
            }
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }


}

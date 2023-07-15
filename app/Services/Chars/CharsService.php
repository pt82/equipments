<?php


namespace App\Services\Chars;


use App\Models\Char;
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

    /**
     * @param $data
     * @throws Exception
     */
    public function updateListCharsFromSW($data)
    {
        try {
            foreach ($data as $char) {
                $model = Char::query()->where('external_id', $char['base_id'])->first();
                if (!$model) {
                    $model = new Char();
                    $model->name = $char['name'];
                    $model->external_id =  $char['base_id'];
                    $model->url = $char['url'];
                    $model->save();
                }
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


}

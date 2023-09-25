<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Char;
use App\Models\Char_Member;
use App\Models\Import;
use App\Models\Member;
use App\Services\Chars\CharsService;
use App\Services\Client\ApiSwgohHelp;
use App\Services\Data\DataService;
use App\Services\Member\MembersService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class SwController extends Controller
{

    /**
     * Инфо о гильдии
     *
     * @return JsonResponse
     */
    public function index()
    {

        $client = new ApiSwgohHelp();
        $service = new MembersService();
        return $service->getMembersFromSW();
//        $response  = $client->fetchGiInfo('52313');
        $response = $client->fetchChars();
        $responseBody = $client->getResponseBody($response);
        foreach ($responseBody as $char) {
            $model = Char::query()->where('external_id', $char->base_id)->first();
            if (!$model) {
                $model = new Char();
                $model->name = $char->name;
                $model->external_id = $char->base_id;
                $model->url = $char->url;
                $model->save();
            }

        }

        return $this->sendResponse($responseBody, "GiInfo");


//       return $gui =   Curl::to('https://swgoh.gg/api/guild/52313')
//            ->withContentType('application/json')
////          ->withOption('USERPWD', 'kaban92:Kmt4675002') //работает
////        ->withHeader('Authorization: Basic username=kaban92, password=Kmt4675002' )
//            ->asJson()
//            ->asJsonResponse()
//            ->get();
    }

    public function listMembers()
    {
        $service = new MembersService();
        return $this->sendResponse($service->loadModels(), "MembersService");
    }

    public function loadData()
    {
        $result = [];
        try {
//            if (Import::query()->where('gi_id', 52313)->where('status', '!=', Import::STATUS_FINISH)->latest()) {
//                return false;
//            }
            (new DataService())->deleteAll();
            $import = new Import();
            $import->gi_id = 52313;
            $import->status = Import::STATUS_START;
            $import->save();
            DB::transaction(function () use ($import) {
                $import->saveStatus(Import::STATUS_PROCESS);
                $service = new MembersService();
                $members = $service->loadModels();
                foreach ($members as $member) {
                   $units = $this->getResponse($service->getInfoMember($member->external_id))['units'];
                    foreach ($units as $unit) {
//                        return $unit['data']['ability_data'];
                        $char = Char::query()->where('external_id', $unit['data']['base_id'])->first();
                        $member->chars()->attach($char, [
                            'rel' => (($unit['data']['relic_tier'] > 2) ? ($unit['data']['relic_tier'] - 2) : null),
                            'tir' => $unit['data']['gear_level'],
                            'rarity' => $unit['data']['rarity'],
                            'ability_data' => json_encode($unit['data']['omicron_abilities']) ?? [],
                            'import_id' => $import->id,
                            'gi_id' => 52313,
                        ]);
                    }
                }
            });
            $import->status = Import::STATUS_FINISH;
            $import->save();
        } catch (Exception $exception) {
            $import->saveStatus(Import::STATUS_ERROR);
            return 'Извините, внешняя служба не работает';
        }
        $import->saveStatus(Import::STATUS_FINISH);
        return $this->sendResponse([], "MembersService");

    }


    public function searchData(Request $request)
    {

        $data = [
            'ids' => $request->ids ?? [],
            'rel' => $request->rel ?? '',
        ];
        $service = new CharsService();
        return $this->sendResponse($service->searchChars($data), "Search");

    }

    public function searchDataByChar(Request $request)
    {

        $data = [
            'ids' => $request->ids ?? [],
            'rel' => $request->rel ?? '',
        ];
        $service = new CharsService();
        return $this->sendResponse($service->searchMembers($data), "Search");

    }

    public function updateChars()
    {
        $service = new CharsService();
//return $service->getCharsFromSW();
        $service->updateListCharsFromSW($service->getCharsFromSW(), 'char');

        $service->updateListCharsFromSW($service->getShipsFromSW(), 'ship');

    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function listChars()
    {
        $service = new CharsService();

        return $this->sendResponse($service->getListChars(), "ListChars");
    }

    public function updateMembers()
    {
        $service = new MembersService();

        $service->updateListMembersFromSW($service->getMembersFromSW());

    }

    public function updateInfoMember(Member $member)
    {

        $service = new MembersService();
        return $this->getResponse($service->getInfoMember(324257441));
    }

    /**
     * @param $response
     * @return mixed
     * @throws \Exception
     */
    private function getResponse($response)
    {
        $client = new ApiSwgohHelp();

        return $client->getResponseBody($response);
    }


}

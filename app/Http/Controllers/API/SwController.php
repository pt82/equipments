<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Char;
use App\Services\Chars\CharsService;
use App\Services\Client\ApiSwgohHelp;
use App\Services\Member\MembersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



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
//        $response  = $client->fetchGiInfo('52313');
        $response  = $client->fetchChars();
        $responseBody = $client->getResponseBody($response);
        foreach ($responseBody as $char)
        {
            $model = Char::query()->where('external_id', $char->base_id)->first();
            if(!$model) {
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
        $servise = new MembersService();
        return $this->sendResponse($servise->loadModels(), "MembersService");
    }

    public function updateChars()
    {
        $service = new CharsService();

        $service->updateListCharsFromSW($service->getCharsFromSW());

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
        $service = new CharsService();

        $service->updateListCharsFromSW($service->getCharsFromSW());

    }
}

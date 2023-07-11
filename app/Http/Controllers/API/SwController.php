<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Client\ApiSwgohHelp;
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
        $response  = $client->fetchGiInfo('52313');
        $responseBody = $client->getResponseBody($response);

        return $this->sendResponse($responseBody, "GiInfo");
//       return $gui =   Curl::to('https://swgoh.gg/api/guild/52313')
//            ->withContentType('application/json')
////          ->withOption('USERPWD', 'kaban92:Kmt4675002') //работает
////        ->withHeader('Authorization: Basic username=kaban92, password=Kmt4675002' )
//            ->asJson()
//            ->asJsonResponse()
//            ->get();
    }
}

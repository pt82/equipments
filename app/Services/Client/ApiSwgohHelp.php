<?php


namespace App\Services\Client;


use Exception;
use GuzzleHttp\Client;

class ApiSwgohHelp
{
    /**
     * @var string
     */
    private $baseUrl = 'https://swgoh.gg/api/';
    /**
     * @var Client
     */
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function login() {

        try {
            $opts = array(
                'http'=>array(
                    'method'=>"POST",
                    'header'=>"Content-Type: application/x-www-form-urlencoded",
                    'content'=>$this->user
                )
            );
            $context = stream_context_create($opts);
            $auth = file_get_contents($this->signin, false, $context);
            $obj = json_decode($auth);

            if( !isset($obj->access_token) ) {
                throw new Exception('! Cannot login with these credentials');
            }

          return  $this->token = "Authorization:Bearer ".$obj->access_token;

        } catch(Exception $e) {
            throw $e;
        }

    }

    private function fetchAPI($url, $method = 'GET' ) {
        try {
           return $this->client->request($method, $this->baseUrl . $url);

       } catch(Exception $e) {
            throw $e;
        }

    }

    public function fetchGiInfo($data) {
        try {
            return $this->fetchAPI('guild/' . $data);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function fetchChars() {
        try {
            return $this->fetchAPI('characters/');
        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $response
     * @return mixed
     * @throws Exception
     */
    public function getResponseBody($response)
    {
        try {
            return json_decode($response->getBody(), true);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function fetchPlayer( $allycode ) {
        try {
            return $this->fetchAPI( $this->player, $allycode );
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function fetchGuild( $allycode ) {
        try {
            return $this->fetchAPI( $this->guild, $allycode );
        } catch(Exception $e) {
            throw $e;
        }
    }

}

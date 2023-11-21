<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class GetCompanyService
{
    private $getCompanyDataManagerService;

    public function __construct(GetCompanyDataManagerService $getCompanyDataManagerService)
    {
        $this->getCompanyDataManagerService = $getCompanyDataManagerService;
    }

    // Api's functions

    // creating and executing http requests

    private function gusApiQuery(string $url, string $params, ?string $sid)
    {        

        $httpClient = HttpClient::create();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'sid' => $sid
            ],
            'body' => $params
        ];

        $response = $httpClient->request('POST', $url, $options);
        if ($response->getStatusCode() == 200 && strlen($response->getContent()) > 0) {
            if ($sid == null) {
                return json_decode($response->getContent())->d;
            } else {
                return json_decode(str_replace('\u000d\u000a','',$response->getContent()))->d;
                //return $response;
                //return json_decode($response->getContent());
            }
            
        } else {
            return null;
        }

    }

    // Creating session

    public function login(string $url, string $user)
    {
        $params = json_encode([
            'pKluczUzytkownika' => $user
        ]);

        return $this->gusApiQuery($url, $params, null);
    }

    // Getting company info

    public function getCompany(string $url, string $regon, $sid) : int
    {
        $params = json_encode([
            'pParametryWyszukiwania' => [
                'Regon' => $regon
            ]
        ]);

        $data = $this->gusApiQuery($url, $params, $sid);
        if (strlen($data) > 0) {
            return $this->getCompanyDataManagerService->uploadData($data);
        } else {
            return 0;
        }
    }
}
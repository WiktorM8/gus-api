<?php

namespace App\Service;


class GetDataFromDatabaseService
{
    public function prepareJsonResponse($companies)
    {   
        $data = [];
        foreach ($companies as $company) {
            $data[] = [
                'regon' => $company->getRegon(),
                'nazwa' => $company->getNazwa(),
                'wojewodztwo' => $company->getWojewodztwo(),
                'powiat' => $company->getPowiat(),
                'gmina' => $company->getGmina(),
                'miejscowosc' => $company->getMiejscowosc(),
                'kod_pocztowy' => $company->getKodPocztowy(),
                'ulica' => $company->getUlica(),
                'typ' => $company->getTyp(),
                'silosID' => $company->getSilosID()
            ];
        }

        return $data;
    }
}
<?php
declare(strict_types = 1);

namespace App\Service;


class GetDataFromDatabaseService
{
    public function prepareJsonResponse($companies) : array
    {   
        $data = [];
        foreach ($companies as $company) {
            $data[] = [
                'regon' => $company->getRegon(),
                'name' => $company->getName(),
                'voivodeship' => $company->getVoivodeship(),
                'county' => $company->getCounty(),
                'commune' => $company->getCommune(),
                'town' => $company->getTown(),
                'postal_code' => $company->getPostalCode(),
                'street' => $company->getStreet(),
                'type' => $company->getType(),
                'silosID' => $company->getSilosID()
            ];
        }

        return $data;
    }
}
<?php

namespace App\Tests\Service;

use App\Entity\RegonData;
use App\Service\GetDataFromDatabaseService;
use PHPUnit\Framework\TestCase;

class GetDataFromDatabaseServiceTest extends TestCase
{
    public function testPrepareJsonResponse()
    {
        $company = new RegonData();
        $company->setRegon('123456789');
        $company->setName('Test Company');
        $company->setVoivodeship('Mazowieckie');
        $company->setCounty('Warszawa');
        $company->setCommune('Warszawa');
        $company->setTown('Warszawa');
        $company->setPostalCode('00-001');
        $company->setStreet('ul. Testowa 1');
        $company->setType('1');
        $company->setSilosID('ABC123');

        $companies = [$company];

        $getDataFromDatabaseService = new GetDataFromDatabaseService();

        $result = $getDataFromDatabaseService->prepareJsonResponse($companies);

        $expected = [
            [
                'regon' => '123456789',
                'name' => 'Test Company',
                'voivodeship' => 'Mazowieckie',
                'county' => 'Warszawa',
                'commune' => 'Warszawa',
                'town' => 'Warszawa',
                'postal_code' => '00-001',
                'street' => 'ul. Testowa 1',
                'type' => '1',
                'silosID' => 'ABC123'
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}

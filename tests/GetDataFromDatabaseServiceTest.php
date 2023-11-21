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
        $company->setNazwa('Test Company');
        $company->setWojewodztwo('Mazowieckie');
        $company->setPowiat('Warszawa');
        $company->setGmina('Warszawa');
        $company->setMiejscowosc('Warszawa');
        $company->setKodPocztowy('00-001');
        $company->setUlica('ul. Testowa 1');
        $company->setTyp('S.A.');
        $company->setSilosID('ABC123');

        $companies = [$company];

        $getDataFromDatabaseService = new GetDataFromDatabaseService();

        $result = $getDataFromDatabaseService->prepareJsonResponse($companies);

        $expected = [
            [
                'regon' => '123456789',
                'nazwa' => 'Test Company',
                'wojewodztwo' => 'Mazowieckie',
                'powiat' => 'Warszawa',
                'gmina' => 'Warszawa',
                'miejscowosc' => 'Warszawa',
                'kod_pocztowy' => '00-001',
                'ulica' => 'ul. Testowa 1',
                'typ' => 'S.A.',
                'silosID' => 'ABC123'
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}

<?php

use App\Service\GetCompanyService;
use App\Service\GetCompanyDataManagerService;
use PHPUnit\Framework\TestCase;

class GetCompanyServiceTest extends TestCase
{
    public function testLogin()
    {
        $getCompanyDataManagerServiceMock = $this->createMock(GetCompanyDataManagerService::class);

        $getCompanyService = new GetCompanyService($getCompanyDataManagerServiceMock);

        $realUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/Zaloguj';
        $realUser = 'abcde12345abcde12345';

        $result = $getCompanyService->login($realUrl, $realUser);

        $this->assertNotEmpty($result);
    }

    public function testGetCompany()
    {
        $getCompanyDataManagerServiceMock = $this->createMock(GetCompanyDataManagerService::class);

        $getCompanyService = new GetCompanyService($getCompanyDataManagerServiceMock);

        $realUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/daneSzukaj';
        $realRegon = '331399589';
        $realSid = $getCompanyService->login(
            'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/Zaloguj',
            'abcde12345abcde12345'
        );

        $getCompanyDataManagerServiceMock->expects($this->once())
            ->method('uploadData')
            ->willReturn(true);

        $result = $getCompanyService->getCompany($realUrl, $realRegon, $realSid);

        $this->assertEquals(1, $result);
    }
}


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

        $result = $getCompanyService->login();

        $this->assertNotEmpty($result);
    }

    public function testGetCompany()
    {
        $getCompanyDataManagerServiceMock = $this->createMock(GetCompanyDataManagerService::class);

        $getCompanyService = new GetCompanyService($getCompanyDataManagerServiceMock);

        $realRegon = '331399589';
        $realSid = $getCompanyService->login();

        $getCompanyDataManagerServiceMock->expects($this->once())
            ->method('uploadData')
            ->willReturn(1);

        $result = $getCompanyService->getCompany($realRegon, $realSid);

        $this->assertEquals(1, $result);
    }
}


<?php

namespace App\Tests\Service;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ObjectRepository;
use App\Entity\RegonData;
use App\Service\HandleGetDataFromDatabaseService;
use Symfony\Component\HttpFoundation\Response;

class GetDataFromDatabaseServiceTest extends TestCase
{
    public function testHandleRequest()
    {
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $repositoryMock = $this->createMock(ObjectRepository::class);

        $repositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn([
                (new RegonData())
                    ->setRegon('01077128000000')
                    ->setName('"UPS POLSKA" SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ')
                    ->setVoivodeship('MAZOWIECKIE')
                    ->setCounty('m. st. Warszawa')
                    ->setCommune('Wola')
                    ->setTown('Warszawa')
                    ->setPostalCode('01-222')
                    ->setStreet('ul. Test-Krucza')
                    ->setType('P')
                    ->setSilosID(6)
            ]);

        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(RegonData::class)
            ->willReturn($repositoryMock);

        $getDataFromDatabaseService = new HandleGetDataFromDatabaseService($entityManagerMock);

        $result = $getDataFromDatabaseService->handleRequest();

        $this->assertEquals('ApiResult', $result[0]);
        $this->assertEquals([ 0 => [
            "regon"=> "01077128000000",
            "name"=> '"UPS POLSKA" SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ',
            "voivodeship"=> "MAZOWIECKIE",
            "county"=> "m. st. Warszawa",
            "commune"=> "Wola",
            "town"=> "Warszawa",
            "postal_code"=> "01-222",
            "street"=> "ul. Test-Krucza",
            "type"=> "P",
            "silosID"=> "6"
            ]] , $result[1]);
        $this->assertEquals(Response::HTTP_OK, $result[2]);
    }
}
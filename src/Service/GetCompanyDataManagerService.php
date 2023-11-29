<?php
declare(strict_types = 1);

namespace App\Service;

use App\Entity\RegonData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class GetCompanyDataManagerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function xmlDecodeData(string $data) : array
    {
        $xmlEncoder = new XmlEncoder();
        return $xmlEncoder->decode($data, 'xml');
    }

    private function insertToDatabase(array $xmlDecodedData) : int
    {
        try {
            $entityRegonData = new RegonData();
            $entityRegonData->setRegon($xmlDecodedData['dane']['Regon']);
            $entityRegonData->setName($xmlDecodedData['dane']['Nazwa']);
            $entityRegonData->setVoivodeship($xmlDecodedData['dane']['Wojewodztwo']);
            $entityRegonData->setCounty($xmlDecodedData['dane']['Powiat']);
            $entityRegonData->setCommune($xmlDecodedData['dane']['Gmina']);
            $entityRegonData->setTown($xmlDecodedData['dane']['Miejscowosc']);
            $entityRegonData->setPostalCode($xmlDecodedData['dane']['KodPocztowy']);
            $entityRegonData->setStreet($xmlDecodedData['dane']['Ulica']);
            $entityRegonData->setType($xmlDecodedData['dane']['Typ']);
            $entityRegonData->setSilosID($xmlDecodedData['dane']['SilosID']);

            $this->entityManager->persist($entityRegonData);
            $this->entityManager->flush();
            // everything is fine
            return 1;

        } catch (Exception $e) {
            // database error
            return 2;
        }
    }

    private function updateDatabase(array $xmlDecodedData) : int
    {
        try {
            $existingEntity = $this->entityManager->getRepository(RegonData::class)->findCompanyWithRegon($xmlDecodedData['dane']['Regon']);

            if ($existingEntity instanceof RegonData) {
                $existingEntity->setName($xmlDecodedData['dane']['Nazwa']);
                $existingEntity->setVoivodeship($xmlDecodedData['dane']['Wojewodztwo']);
                $existingEntity->setCounty($xmlDecodedData['dane']['Powiat']);
                $existingEntity->setCommune($xmlDecodedData['dane']['Gmina']);
                $existingEntity->setTown($xmlDecodedData['dane']['Miejscowosc']);
                $existingEntity->setPostalCode($xmlDecodedData['dane']['KodPocztowy']);
                $existingEntity->setStreet($xmlDecodedData['dane']['Ulica']);
                $existingEntity->setType($xmlDecodedData['dane']['Typ']);
                $existingEntity->setSilosID($xmlDecodedData['dane']['SilosID']);

                $this->entityManager->flush();

                // Everything is fine
                return 1;
            } else {
                // Entity not found
                return 2;
            }
        } catch (Exception $e) {
            // Database error
            return 2;
        }
    }

    public function uploadData(string $data) : int
    {
        $xmlDecodedData = $this->xmlDecodeData($data);
        if (count($this->entityManager->getRepository(RegonData::class)->findBy(['regon' => $xmlDecodedData['dane']['Regon']])) > 0) {
            // update existing record in database
            return $this->updateDatabase($xmlDecodedData);
        } else {
            // add new record to database
            return $this->insertToDatabase($xmlDecodedData);
        }
            
    }
}
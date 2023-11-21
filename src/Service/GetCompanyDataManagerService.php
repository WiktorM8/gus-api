<?php

namespace App\Service;

use App\Entity\RegonData;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class GetCompanyDataManagerService
{
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    private function xmlDecodeData(string $data) : array
    {
        $xmlEncoder = new XmlEncoder();
        return $xmlEncoder->decode($data, 'xml');
    }

    private function insertToDatabase(array $xmlDecodedData)
    {
        try {
            $entityRegonData = new RegonData();
            $entityRegonData->setRegon($xmlDecodedData['dane']['Regon']);
            $entityRegonData->setNazwa($xmlDecodedData['dane']['Nazwa']);
            $entityRegonData->setWojewodztwo($xmlDecodedData['dane']['Wojewodztwo']);
            $entityRegonData->setPowiat($xmlDecodedData['dane']['Powiat']);
            $entityRegonData->setGmina($xmlDecodedData['dane']['Gmina']);
            $entityRegonData->setMiejscowosc($xmlDecodedData['dane']['Miejscowosc']);
            $entityRegonData->setKodPocztowy($xmlDecodedData['dane']['KodPocztowy']);
            $entityRegonData->setUlica($xmlDecodedData['dane']['Ulica']);
            $entityRegonData->setTyp($xmlDecodedData['dane']['Typ']);
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

    private function updateDatabase(array $xmlDecodedData)
    {
        try {
            $existingEntity = $this->entityManager->getRepository(RegonData::class)->findOneBy(['regon' => $xmlDecodedData['dane']['Regon']]);

            if ($existingEntity instanceof RegonData) {
                $existingEntity->setNazwa($xmlDecodedData['dane']['Nazwa']);
                $existingEntity->setWojewodztwo($xmlDecodedData['dane']['Wojewodztwo']);
                $existingEntity->setPowiat($xmlDecodedData['dane']['Powiat']);
                $existingEntity->setGmina($xmlDecodedData['dane']['Gmina']);
                $existingEntity->setMiejscowosc($xmlDecodedData['dane']['Miejscowosc']);
                $existingEntity->setKodPocztowy($xmlDecodedData['dane']['KodPocztowy']);
                $existingEntity->setUlica($xmlDecodedData['dane']['Ulica']);
                $existingEntity->setTyp($xmlDecodedData['dane']['Typ']);
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

    public function uploadData(string $data)
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
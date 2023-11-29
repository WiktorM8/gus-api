<?php
declare(strict_types = 1);

namespace App\Service;

use App\Entity\RegonData;
use Doctrine\ORM\EntityManagerInterface;
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

    private function setEntityProperties(RegonData $entityRegonData, array $xmlDecodedData) : void
    {
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
    }

    private function insertToDatabase(array $xmlDecodedData) : int
    {
        try {
            $entityRegonData = new RegonData();
            
            $this->setEntityProperties($entityRegonData, $xmlDecodedData);

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
            $existingEntity = $this->entityManager->getRepository(RegonData::class)->findCompanyByRegon($xmlDecodedData['dane']['Regon']);

            if ($existingEntity instanceof RegonData) {

                $this->setEntityProperties($existingEntity, $xmlDecodedData);
                
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
<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\RegonData;

class HandleGetDataFromDatabaseService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function prepareJsonResponse($companies) : array
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

    public function handleRequest()
    {
        try {
            $companies = $this->entityManager->getRepository(RegonData::class)->findAll();
            if (count($companies) == 0) {
                return [
                    'ApiError',
                    'There is no companies in database.',
                    Response::HTTP_NOT_FOUND
                ];
            }

            $apiResult = $this->prepareJsonResponse($companies);

            return [
                'ApiResult',
                $apiResult,
                Response::HTTP_OK
            ];

        } catch (Exception $e) {
            return [
                'ApiError',
                'Database error. Unable to retrieve data from the database.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
}
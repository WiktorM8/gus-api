<?php

namespace App\Controller;

use App\Entity\RegonData;
use App\Service\GetDataFromDatabaseService;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegonGetDataFromDatabaseController extends AbstractController
{
    protected $entityManager;
    protected $getDataFromDatabaseService;

    public function __construct(ManagerRegistry $doctrine, GetDataFromDatabaseService $getDataFromDatabaseService)
    {
        $this->entityManager = $doctrine->getManager();
        $this->getDataFromDatabaseService = $getDataFromDatabaseService;
    }

    #[Route('/api/regon', methods: ['GET'])] 
    public function getDataFromDatabase()
    {
        try {
            $companies = $this->entityManager->getRepository(RegonData::class)->findAll();
            if (count($companies) == 0) {
                return new StreamedJsonResponse([
                    'ApiError' => 'There is no companies in database.'
                ]);
            }
        } catch (Exception $e) {
            return new StreamedJsonResponse([
                'ApiError' => 'Database error. Unable to retrieve data from the database.'
            ]);
        }
        
        $apiResult = $this->getDataFromDatabaseService->prepareJsonResponse($companies);

        return new StreamedJsonResponse([
            'ApiResult' => $apiResult
        ]);
    }
}

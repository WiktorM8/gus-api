<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\RegonData;
use App\Service\GetDataFromDatabaseService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegonGetDataFromDatabaseController extends AbstractController
{
    protected $entityManager;
    protected $getDataFromDatabaseService;

    public function __construct(EntityManagerInterface $entityManager, GetDataFromDatabaseService $getDataFromDatabaseService)
    {
        $this->entityManager = $entityManager;
        $this->getDataFromDatabaseService = $getDataFromDatabaseService;

    }

    #[Route('/api/regon', methods: ['GET'])] 
    public function getDataFromDatabase() : StreamedJsonResponse
    {
        try {
            $companies = $this->entityManager->getRepository(RegonData::class)->findAll();
            if (count($companies) == 0) {
                return new StreamedJsonResponse([
                    'ApiError' => 'There is no companies in database.'
                ], Response::HTTP_NOT_FOUND
            );
            }
        } catch (Exception $e) {
            return new StreamedJsonResponse([
                'ApiError' => 'Database error. Unable to retrieve data from the database.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        
        $apiResult = $this->getDataFromDatabaseService->prepareJsonResponse($companies);

        return new StreamedJsonResponse([
            'ApiResult' => $apiResult
        ], Response::HTTP_OK
    );
    }
}

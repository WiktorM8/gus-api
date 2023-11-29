<?php
declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\HandleGetDataFromDatabaseService;

class RegonGetDataFromDatabaseController extends AbstractController
{
    protected $getDataFromDatabaseService;

    public function __construct(HandleGetDataFromDatabaseService $getDataFromDatabaseService)
    {
        
        $this->getDataFromDatabaseService = $getDataFromDatabaseService;

    }

    #[Route('/api/regon', methods: ['GET'])] 
    public function getDataFromDatabase() : StreamedJsonResponse
    {

        $result = $this->getDataFromDatabaseService->handleRequest();

        // $result = [My api response name, My api response message, http status code]
        return new StreamedJsonResponse([
            $result[0] => $result[1]
        ], $result[2]
        );
    }
}

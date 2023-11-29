<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Service\GetCompanyService;
use App\Service\HandleGetCompanyService;
use App\Service\VerifyRegonService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegonGetCompanyController extends AbstractController
{
        //$regon = '010771280';
        //$regon = '331399589';
        //$regon = '141967744';
        //$regon = '170106146';
        //$regon = '123456785'; // correct but non-existent regon

    protected $handleGetCompanyService;

    public function __construct(HandleGetCompanyService $handleGetCompanyService)
    {
        $this->handleGetCompanyService = $handleGetCompanyService;
    }

    #[Route('/api/regon', methods: ['POST'])] 
    public function getCompany(Request $request) : StreamedJsonResponse
    {
        $regon = $request->query->get('regon');

        $result  = $this->handleGetCompanyService->handleRequest($regon);

        // $result = [My api response name, My api response message, http status code]
        return new StreamedJsonResponse([
            $result[0] => $result[1]
        ], $result[2]
    );

    }
}

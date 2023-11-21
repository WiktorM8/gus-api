<?php

namespace App\Controller;

use App\Service\GetCompanyService;
use App\Service\VerifyRegonService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegonGetCompanyController extends AbstractController
{
    public $gusRegonApiSession = null;

    protected $getCompanyService;
    protected $verifyRegonService;
    protected $entityManager;
    protected $gusRegonApiLoginUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/Zaloguj';
    protected $gusRegonApiSearchDataUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/daneSzukaj';

    // User used to comunicate with Gus Regon API
    protected $user = 'abcde12345abcde12345';


    public function __construct(GetCompanyService $getCompanyService, VerifyRegonService $verifyRegonService, ManagerRegistry $doctrine)
    {
        $this->getCompanyService = $getCompanyService;
        $this->verifyRegonService = $verifyRegonService;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/api/regon', methods: ['POST'])] 
    public function getCompany()
    {
        $request = new Request($_GET);
        $regon = $request->query->get('regon');

        //$regon = '010771280';
        //$regon = '331399589';
        //$regon = '141967744';
        //$regon = '170106146';
        //$regon = '123456785'; //-poprawny regon ale nie istniejąca firma

        if (!$this->verifyRegonService->verifyRegon($regon)) {
            return new StreamedJsonResponse([
                'ApiError' => 'Trying to get company with non-existent regon in /api/regon. Consider checking if your regon is correct.'
            ]);
        } else {
            // Check if session exist
            if ($this->gusRegonApiSession == null) {

                // Create session
                $this->gusRegonApiSession = $this->getCompanyService->login($this->gusRegonApiLoginUrl, $this->user, $this->gusRegonApiSession);

                // Check if session exist once again, if not it means user is incorrect
                if ($this->gusRegonApiSession == null) {
                    return new StreamedJsonResponse([
                        'ApiError' => 'Invalid user set in /api/regon.'
                    ]);
                } else {
                    // Update or Insert record to database
                    $resGetCompany = $this->getCompanyService->getCompany($this->gusRegonApiSearchDataUrl, $regon, $this->gusRegonApiSession);
                    if ($resGetCompany == 1) {
                        return new StreamedJsonResponse([
                            'ApiInfo' => 'Company with regon number: '.$regon.' has been successfully added to database. You can access that data by using method \'get\'.'
                        ]);
                    } else if ($resGetCompany == 2) {
                        return new StreamedJsonResponse([
                            'ApiError' => 'Error while trying to connect to database.'
                        ]);
                    } else {
                        return new StreamedJsonResponse([
                            'ApiError' => 'There is no company with provided regon number.'
                        ]);
                    }
                }
            }
        }
    }
}

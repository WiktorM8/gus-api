<?php
declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class HandleGetCompanyService
{
    // Gus Api session
    protected $gusRegonApiSession = null;

    protected $getCompanyService;
    protected $verifyRegonService;
    protected $entityManager;

    public function __construct(GetCompanyService $getCompanyService, VerifyRegonService $verifyRegonService, EntityManagerInterface $entityManager)
    {
        $this->getCompanyService = $getCompanyService;
        $this->verifyRegonService = $verifyRegonService;
        $this->entityManager = $entityManager;
    }

    public function handleRequest(string $regon) : array
    {
        if (!$this->verifyRegonService->verifyRegon($regon)) {
            return [
                'ApiError', 
                'Trying to get company with non-existent regon in /api/regon. Consider checking if your regon is correct.', 
                Response::HTTP_NOT_FOUND
            ];
        } else {
            // Check if session exist
            if ($this->gusRegonApiSession == null) {

                // Create session
                $this->gusRegonApiSession = $this->getCompanyService->login($this->gusRegonApiSession);

                // Check if session exist once again, if not it means user is incorrect
                if ($this->gusRegonApiSession == null) {
                    return [
                        'ApiError',
                        'Invalid user set in /api/regon.',
                        Response::HTTP_UNAUTHORIZED
                    ];
                } else {
                    // Update or Insert record to database
                    $resGetCompany = $this->getCompanyService->getCompany($regon, $this->gusRegonApiSession);
                    if ($resGetCompany == 1) {
                        return [
                            'ApiInfo',
                            'Company with regon number: '.$regon.' has been successfully added to database. You can access that data by using method \'get\'.',
                            Response::HTTP_OK
                        ];
                    } else if ($resGetCompany == 2) {
                        return [
                            'ApiError',
                            'Error while trying to connect to database.',
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        ];
                    } else {
                        return [
                            'ApiError',
                            'There is no company with provided regon number.',
                            Response::HTTP_NOT_FOUND
                        ];
                    }
                }
            }
        }
    }
}
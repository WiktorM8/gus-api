<?php

use App\Service\VerifyRegonService;
use PHPUnit\Framework\TestCase;

class VerifyRegonServiceTest extends TestCase
{
    public function testValidRegon9Digits()
    {
        $verifyRegonService = new VerifyRegonService();
        $result = $verifyRegonService->verifyRegon('123456785');
        $this->assertTrue($result);
    }

    public function testInvalidRegon9Digits()
    {
        $verifyRegonService = new VerifyRegonService();
        $result = $verifyRegonService->verifyRegon('123456789');
        $this->assertFalse($result);
    }

    public function testValidRegon14Digits()
    {
        $verifyRegonService = new VerifyRegonService();
        $result = $verifyRegonService->verifyRegon('12345678901235');
        $this->assertTrue($result);
    }

    public function testInvalidRegon14Digits()
    {
        $verifyRegonService = new VerifyRegonService();
        $result = $verifyRegonService->verifyRegon('12345678901234');
        $this->assertFalse($result);
    }

    public function testInvalidRegonLength()
    {
        $verifyRegonService = new VerifyRegonService();
        $result = $verifyRegonService->verifyRegon('1234567');
        $this->assertFalse($result);
    }
}
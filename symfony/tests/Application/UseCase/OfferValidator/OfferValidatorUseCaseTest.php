<?php

namespace App\Tests\Application\UseCase\OfferValidator;

use App\Application\UseCase\OfferValidator\OfferValidatorRequest;
use App\Application\UseCase\OfferValidator\OfferValidatorUseCase;
use App\Infrastructure\Service\OfferValidatorService;
use PHPUnit\Framework\TestCase;

class OfferValidatorUseCaseTest extends TestCase
{
    public function testOk()
    {
        $request = new OfferValidatorRequest();
        $service = $this->createService();
        $useCase = new OfferValidatorUseCase($service);
        $response = $useCase->run($request);
        $this->assertJson($response);
    }

    private function createService(): OfferValidatorService
    {

        return new OfferValidatorService();
    }
}

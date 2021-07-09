<?php

namespace App\Tests\Infrastructure\Service;

use App\Domain\Service\OfferValidatorServiceInterface;
use App\Infrastructure\Service\OfferValidatorService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class OfferValidatorServiceTest extends TestCase
{
    protected $offerValidatorService;

    /**
     * @return MockObject|OfferValidatorServiceInterface
     */
    protected function getOfferValidatorService()
    {
        return $this->offerValidatorService = $this->offerValidatorService ?: $this->createMock(OfferValidatorServiceInterface::class);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws CustomerNotFoundException
     */
    public function testShouldReturnCustomerSnapshotIfOperationIsNotActive(): void
    {
        $offerValidatorService = new OfferValidatorService();

        $offersAboveAverage = $offerValidatorService->validateOffers();
        $this->assertIsArray($offersAboveAverage);
        $this->assertArrayHasKey('5', $offersAboveAverage);
    }

}
<?php


namespace App\Application\UseCase\OfferValidator;


use App\Domain\Service\OfferValidatorServiceInterface;

class OfferValidatorUseCase
{

    /** @var OfferValidatorServiceInterface */
    private $managerService;

    public function __construct(
        OfferValidatorServiceInterface $managerService
    )
    {
        $this->managerService = $managerService;
    }

    /**
     * @param OfferValidatorRequest $request
     * @return false|string
     */
    public function run(OfferValidatorRequest $request)
    {
        $result = $this->managerService->validateOffers();

        return json_encode([
            'result' => $result
        ]);
    }
}
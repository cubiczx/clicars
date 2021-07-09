<?php

namespace App\Command;

use App\Application\UseCase\OfferValidator\OfferValidatorRequest;
use App\Application\UseCase\OfferValidator\OfferValidatorUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class OfferValidatorCommand
 * @package App\Command
 */
class OfferValidatorCommand extends Command
{

    protected static $defaultName = 'drinks-co:offer-validator';

    /** @var OfferValidatorUseCase */
    protected $useCase;

    public function __construct(OfferValidatorUseCase $useCase)
    {
        parent::__construct();
        $this->useCase = $useCase;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Validate offers suspected of having a wrong price');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->newLine();
        $io->note('Validating offers suspected of having a wrong price...');
        $io->newLine();

        $request = new OfferValidatorRequest();
        $response = $this->useCase->run($request);
        if (json_decode($response, true)['result']) {
            $io->success('Offers that are above average!');
            var_dump(json_decode($response, true)['result']);
        } else {
            $io->error('Error validating offers suspected of having a wrong price!');
        }

        return 0;
    }
}

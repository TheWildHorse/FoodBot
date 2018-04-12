<?php

namespace App\Command;

use App\Services\Import\FoodImportService;
use App\Services\Scrapers\MenuScraperInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDailyMenuCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'import:menu:daily';

    protected function configure()
    {
        $this
            ->setDescription('Imports menus from all providers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $importers = [
            \App\Services\Scrapers\FontanaCrnkovicScraper::class,
            \App\Services\Scrapers\ZujaBarScraper::class
        ];
        $results = [];
        foreach($importers as $importerClass) {
            /** @var MenuScraperInterface $importerInstance */
            $importerInstance = $this->getContainer()->get($importerClass);
            $results = array_merge($results, $importerInstance->fetchDailyFood());
        }

        /** @var FoodImportService $importService */
        $importService = $this->getContainer()->get(\App\Services\Import\FoodImportService::class);
        $importService->deleteDailyFoods();
        $importService->importFoods($results);

        $io->success('All importers ran successfully!');
    }
}

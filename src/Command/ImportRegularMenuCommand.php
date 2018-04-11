<?php

namespace App\Command;

use App\Services\Importers\MenuImporterInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportRegularMenuCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'import:menu:regular';

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
            \App\Services\Importers\FontanaCrnkovicImporter::class,
            \App\Services\Importers\ZujaBarImporter::class
        ];
        $results = [];
        foreach($importers as $importerClass) {
            /** @var MenuImporterInterface $importerInstance */
            $importerInstance = $this->getContainer()->get($importerClass);
            $results = array_merge($results, $importerInstance->fetchRegularFood());
        }

        // ToDo: Implement persistance layer

        $io->success('All importers ran successfully!');
    }
}

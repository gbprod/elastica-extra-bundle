<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to reindex
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ReindexCommand extends ElasticaAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elasticsearch:reindex')
            ->setDescription('Reindex an old index to the new one')
            ->addArgument('old-index', InputArgument::REQUIRED, 'Old index')
            ->addArgument('new-index', InputArgument::REQUIRED, 'New index')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $oldIndex = $input->getArgument('old-index');
        $newIndex = $input->getArgument('new-index');

        $output->writeln(sprintf(
            '<info>Reindex <comment>%s</comment> to <comment>%s</comment></info>',
            $oldIndex,
            $newIndex
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elastica_extra.reindex_handler')
        ;

        $handler->handle($client, $oldIndex, $newIndex);

        $output->writeln('done');
    }
}

<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create index
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexCommand extends ElasticaAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:create')
            ->setDescription('Create index from configuration')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', null)
            ->addOption('config', null, InputOption::VALUE_REQUIRED, 'Index configuration to use (if not the same as index argument)', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $index  = $input->getArgument('index');
        $config  = $input->getOption('config') ?: $index;

        $output->writeln(sprintf(
            '<info>Creating index <comment>%s</comment> for client <comment>%s</comment></info>',
            $index,
            $input->getOption('client')
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elastica_extra.create_index_handler')
        ;

        $handler->handle($client, $index, $config);

        $output->writeln('done');
    }
}

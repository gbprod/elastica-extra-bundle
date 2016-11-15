<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to list indices
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ListIndexCommand extends ElasticaAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:list')
            ->setDescription('Index list')
            ->addOption('pattern', '', InputOption::VALUE_REQUIRED, 'Index name filter pattern', null)
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));

        $uri = sprintf('_cat/indices/%s?h=i', $input->getOption('pattern'));

        $response = $client->request($uri);

        $output->writeln($response->getData()['message']);
    }
}

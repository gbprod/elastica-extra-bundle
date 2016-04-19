<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to list aliases
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ListAliasCommand extends ElasticaAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elasticsearch:alias:list')
            ->setDescription('List index aliases')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $index  = $input->getArgument('index');

        $output->writeln(sprintf(
            '<info>Aliases for index <comment>%s</comment></info>',
            $index
        ));

        $aliases = $client
            ->getIndex($index)
            ->getAliases()
        ;

        foreach ($aliases as $alias) {
            $output->writeln(' * ' . $alias);
        }
    }
}

<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to add alias
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AddAliasCommand extends ElasticaAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('elasticsearch:alias:add')
            ->setDescription('Add alias to an index')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addArgument('alias', InputArgument::REQUIRED, 'Alias name')
            ->addOption('replace', null, InputOption::VALUE_NONE, 'If set, an existing alias will be replaced')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client  = $this->getClient($input->getOption('client'));
        $index   = $input->getArgument('index');
        $alias   = $input->getArgument('alias');
        $replace = $input->getOption('replace');

        $output->writeln(sprintf(
            '<info>Add alias <comment>%s</comment> for index <comment>%s</comment></info>',
            $alias,
            $index
        ));

        $this
            ->getContainer()
            ->get('gbprod.elastica_extra.add_alias_handler')
            ->handle($client, $index, $alias, $replace);
        ;

        $output->writeln('done');
    }
}

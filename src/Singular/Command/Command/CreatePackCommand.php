<?php

namespace Singular\Command\Command;


use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreatePackCommand extends Command
{
    public function configure()
    {
        $this->setName('create-pack')
            ->setDescription('Cria e registra um novo pacote na aplicação')
            ->setHelp('Para criar um novo pacote informe o nome do pacote a ser criado. Ex.: Sessao')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Nome do pacote a ser criado. Ex.: Sessao'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
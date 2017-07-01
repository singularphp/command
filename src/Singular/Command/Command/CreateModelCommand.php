<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Classe do comando de criação de um store.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreateModelCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-model')
            ->setDescription('Cria um novo model num pacote')
            ->setHelp('Para criar um novo model, informe o nome do model a ser criado, do pacote e da tabela. 
                Ex.: singular backend:create-model Model Sessao --table=nome_tabela'
            )
            ->addArgument(
                'model',
                InputArgument::REQUIRED,
                'Nome do model a ser criado. Ex.: Model'
            )
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote onde o store será criado. Ex.: Session'
            )
            ->addOption(
                'table',
                null,
                InputOption::VALUE_REQUIRED,
                'Tabela vinculada ao modelo. Ex.: nome_tabela'
            )
            ->addOption(
                'author',
                null,
                InputOption::VALUE_OPTIONAL,
                'Nome do autor do pacote a ser criado. Ex.: Otávio Fernandes'
            )
            ->addOption(
                'email',
                null,
                InputOption::VALUE_OPTIONAL,
                'Email do autor do pacote a ser criado. Ex.: otavio@neton.com.br'
            );

            
        ;
    }

    /**
     * Executa o comando de criação do comando.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $pack = $input->getArgument('pacote');
        $model = $input->getArgument('model');
        $table = $input->getOption('table');

        if (!$table) {
            $table = strtolower($model);
        }

        $author = $input->getOption('author');

        if (!$author) {
            if (isset($app['author.name'])) {
                $author = $app['author.name'];
            } else {
                $author = 'Author';
            }
        }

        $email = $input->getOption('email');

        if (!$email) {
            if (isset($app['author.email'])) {
                $email = $app['author.email'];
            } else {
                $email = 'author@email.com';
            }
        }

        try {
            $app['singular.service.model']->create($model, $pack, $table, $author, $email);
            $output->writeln(sprintf('<info>Modelo "%s" criado com sucesso no pacote %s!</info>',$model, $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

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
class CreateStoreCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-store')
            ->setDescription('Cria um novo store num pacote')
            ->setHelp('Para criar um novo store, informe o nome do store a ser criado, do pacote e do modelo. 
                Ex.: singular backend:create-store Store Sessao Modelo'
            )
            ->addArgument(
                'store',
                InputArgument::REQUIRED,
                'Nome do store a ser criado. Ex.: Store'
            )
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote onde o store será criado. Ex.: Session'
            )
            ->addArgument(
                'model',
                InputArgument::REQUIRED,
                'Modelo vinculado ao store. Ex.: Modelo'
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
        $store = $input->getArgument('store');
        $pack = $input->getArgument('pacote');
        $model = $input->getArgument('model');

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
            $app['singular.service.store']->create($store, $pack, $model, $author, $email);
            $output->writeln(sprintf('<info>Store "%s" criado com sucesso no pacote %s!</info>',$store, $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

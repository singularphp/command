<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Classe do comando de criação de um controlador.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreateControllerCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-controller')
            ->setDescription('Cria um novo controlador num pacote')
            ->setHelp('Para criar um novo controlador, informe o nome do controlador a ser criado e do pacote. Ex.: singular backend:create-controller Controlador Sessao')
            ->addArgument(
                'controlador',
                InputArgument::REQUIRED,
                'Nome do controlador a ser criado. Ex.: Controlador'
            )
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote onde o comando será criado. Ex.: Session'
            )
            ->addOption(
                'crud',
                null,
                InputOption::VALUE_OPTIONAL,
                'Se o controlador a ser criado irá herdar os métodos do controlador de crud do singular'
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
        $controller = $input->getArgument('controlador');
        $pack = $input->getArgument('pacote');
        $crud = (bool) $input->getOption('crud');
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
            $app['singular.service.controller']->create($controller, $pack, $author, $email, $crud);
            $output->writeln(sprintf('<info>Controlador "%s" criado com sucesso no pacote %s!</info>',$controller, $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

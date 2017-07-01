<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Classe do comando de criação de um comando.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreateCommandCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-command')
            ->setDescription('Cria um novo comando num pacote')
            ->setHelp('Para criar um novo comando, informe o nome do comando a ser criado e do pacote. Ex.: singular backend:create-command meu-comando Sessao')
            ->addArgument(
                'comando',
                InputArgument::REQUIRED,
                'Nome do comando a ser criado. Ex.: meu-comando'
            )
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote onde o comando será criado. Ex.: Session'
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
        $command = $input->getArgument('comando');
        $pack = $input->getArgument('pacote');

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
            $app['singular.service.command']->create($command, $pack, $author, $email);
            $output->writeln(sprintf('<info>Comando "%s" criado com sucesso no pacote %s!</info>',$command, $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

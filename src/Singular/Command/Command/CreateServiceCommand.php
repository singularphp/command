<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Classe do comando de criação de um serviço.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreateServiceCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-service')
            ->setDescription('Cria um novo serviço num pacote')
            ->setHelp('Para criar um novo serviço, informe o nome do serviço a ser criado e do pacote. Ex.: singular backend:create-service Servico Sessao')
            ->addArgument(
                'servico',
                InputArgument::REQUIRED,
                'Nome do serviço a ser criado. Ex.: Servico'
            )
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote onde o serviço será criado. Ex.: Session'
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
     * Executa o comando de criação do serviço.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $service = $input->getArgument('servico');
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
            $app['singular.service.service']->create($service, $pack, $author, $email);
            $output->writeln(sprintf('<info>Serviço "%s" criado com sucesso no pacote %s!</info>',$service, $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

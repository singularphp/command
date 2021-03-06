<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe do comando de criação de um pacote.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreatePackCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:create-pack')
            ->setDescription('Cria e habilita um novo pacote na aplicação')
            ->setHelp('Para criar um novo pacote, informe o nome do pacote a ser criado. Ex.: singular backend:create-pack Sessao')
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote a ser criado. Ex.: Sessao'
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
    }

    /**
     * Executa o comando de criação do pacote.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
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
            $app['singular.service.pack']->create($pack, $author, $email);
            $output->writeln(sprintf('<info>Pacote "%s" criado com sucesso!</info>',$pack));

            $app['singular.service.pack']->enable($pack);
            $output->writeln(sprintf('<info>Pacote "%s" ativado com sucesso!</info>', $pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

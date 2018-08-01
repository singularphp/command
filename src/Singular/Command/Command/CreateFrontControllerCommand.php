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
class CreateFrontControllerCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('frontend:create-controller')
            ->setDescription('Cria um controlador de frontend na aplicação')
            ->setHelp(
                'Para criar um novo controlador, informe o nome do controlador a ser criado, o módulo e o diretório do módulo. 
    Exemplo: <info>singular frontend:create-controller usuario.ListCtrl singular.usuario cadastro/usuario --type=common</info>'
            )
            ->addArgument(
                'controlador',
                InputArgument::REQUIRED,
                'Nome do controlador a ser criado. Ex.: usuario.ListCtrl'
            )
            ->addArgument(
                'modulo',
                InputArgument::REQUIRED,
                'Nome do módulo onde o controlador será criado. Ex.: cadastro.usuario'
            )
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'Diretório do módulo onde o controlador  será criado. Ex.: cadastro/usuario'
            )
            ->addOption(
                'type',
                null,
                InputOption::VALUE_OPTIONAL,
                'Tipo de controlador a ser criado. [list, form, modal, common]'
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
        $controlador = $input->getArgument('controlador');
        $modulo = $input->getArgument('modulo');
        $dir = $input->getArgument('dir');

        $type = $input->getOption('type') ?: 'common';

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
            $app['singular.service.front_controller']->create($controlador, $modulo, $dir, $type, $author, $email);
            $output->writeln(sprintf('<info>Controlador "%s" criado com sucesso!</info>',$controlador));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

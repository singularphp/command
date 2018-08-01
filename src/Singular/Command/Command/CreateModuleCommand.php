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
class CreateModuleCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('frontend:create-module')
            ->setDescription('Cria um módulo de frontend na aplicação')
            ->setHelp('Para criar um novo módulo, informe o nome do módulo a ser criado. Opcionalmente informe o diretório destino.
Exemplo: <info>singular frontend:create-module app.usuario --dir=secure</info>')
            ->addArgument(
                'modulo',
                InputArgument::REQUIRED,
                'Nome do modulo a ser criado. Ex.: app.usuario'
            )
            ->addOption(
                'dir',
                null,
                InputOption::VALUE_OPTIONAL,
                'Diretório onde o módulo será criado, a partir do diretório web/src. Ex.: cadastro'
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
        $module = $input->getArgument('modulo');
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

        $dir = $input->getOption('dir');

        if (!$dir) {
            $dir = '';
        }

        try {
            $moduleDir = $app['singular.service.module']->create($module, $dir, $author, $email);
//            $app['singular.service.module_service']->create($module, $moduleDir, $author, $email);
            $output->writeln(sprintf('<info>Módulo "%s" criado com sucesso!</info>',$module));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

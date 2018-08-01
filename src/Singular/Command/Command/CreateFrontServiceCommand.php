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
class CreateFrontServiceCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('frontend:create-service')
            ->setDescription('Cria um serviço de frontend na aplicação')
            ->setHelp(
                'Para criar um novo serviço, informe o nome do serviço a ser criado, o namespace do módulo e o diretório do módulo. 
    Exemplo: <info>singular frontend:create-service Usuario singular.usuario secure/cadastro/usuario</info>'
            )
            ->addArgument(
                'service',
                InputArgument::REQUIRED,
                'Nome do serviço a ser criado. Ex.: UsuarioService'
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
        $service = $input->getArgument('service');
        $modulo = $input->getArgument('modulo');
        $dir = $input->getArgument('dir');

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
            $app['singular.service.front_service']->create($service, $modulo, $dir, $author, $email);
            $output->writeln(sprintf('<info>Serviço "%s" criado com sucesso!</info>',$service));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

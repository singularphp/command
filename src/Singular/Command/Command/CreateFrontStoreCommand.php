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
class CreateFrontStoreCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('frontend:create-store')
            ->setDescription('Cria um store de frontend na aplicação')
            ->setHelp(
                'Para criar um novo store, informe o nome do store a ser criado, 
                o módulo, o pacote backend e o controlador backend e o diretório do módulo. 
                Ex.: singular frontend:create-store Usuario singular.usuario sessao usuario secure/cadastro/usuario'
            )
            ->addArgument(
                'store',
                InputArgument::REQUIRED,
                'Nome do store a ser criado. Ex.: Usuario'
            )
            ->addArgument(
                'modulo',
                InputArgument::REQUIRED,
                'Nome do módulo onde o controlador será criado. Ex.: cadastro.usuario'
            )
            ->addArgument(
                'pack',
                InputArgument::REQUIRED,
                'Pacote de backend para chamada remota. Ex.: sessao'
            )
            ->addArgument(
                'controlador',
                InputArgument::REQUIRED,
                'Controlador de backend para chamada remota. Ex.: usuario'
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
        $store = $input->getArgument('store');
        $modulo = $input->getArgument('modulo');
        $dir = $input->getArgument('dir');
        $pack = $input->getArgument('pack');
        $controlador = $input->getArgument('controlador');

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
            $app['singular.service.front_store']->create($store, $modulo, $pack, $controlador, $dir, $author, $email);
            $output->writeln(sprintf('<info>Store "%s" criado com sucesso!</info>',$store));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

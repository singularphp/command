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
class CreateFrontViewCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('frontend:create-view')
            ->setDescription('Cria uma view de frontend para um módulo na aplicação')
            ->setHelp(
                'Para criar uma nova view, informe o nome da view a ser criada, e o diretório do módulo destino. Opcionalmente, informe o tipo. 
Exemplo: <info>singular frontend:create-view usuario.form cadastro/usuario --type=form</info>'
            )
            ->addArgument(
                'view',
                InputArgument::REQUIRED,
                'Nome da view a ser criada. Ex.: usuario'
            )
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'Diretório do módulo onde o controlador  será criado. Ex.: cadastro/usuario'
            )
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'Tipo de view a ser criada. [list, form, tab, modal, filter]'
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
        $view = $input->getArgument('view');
        $dir = $input->getArgument('dir');
        $type = $input->getArgument('type');

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
            $app['singular.service.front_view']->create($view, $dir, $type, $author, $email);
            $output->writeln(sprintf('<info>View "%s" criada com sucesso!</info>',$view));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

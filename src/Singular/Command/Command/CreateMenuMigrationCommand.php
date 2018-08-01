<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Classe do comando de criação de migrations para os menus.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class CreateMenuMigrationCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('menu:create-migration')
            ->setDescription('Cria migrations para inclusão dos menus no banco de dados')
            ->setHelp('Para criar uma nova migration: singular menu:create-migration');
    }

    /**
     * Executa o comando de criação da migration.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        try {
            $count = $app['singular.service.menu']->create();
            $output->writeln(sprintf('<info>Migrations de %d menus criadas com sucesso!</info>',$count));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

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
class CreateComponentMigrationCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('component:create-migration')
            ->setDescription('Cria migrations para inclusão dos componentes no banco de dados')
            ->setHelp('Para criar uma nova migration: singular component:create-migration');
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

        try {
            $count = $app['singular.service.create_component_migration']->create();
            $output->writeln(sprintf('<info>Migrations de %d componentes criadas com sucesso!</info>',$count));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

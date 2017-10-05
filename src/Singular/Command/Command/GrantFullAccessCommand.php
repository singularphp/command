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
class GrantFullAccessCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('component:grant-full-access')
            ->setDescription('Concede permissão de acesso a todos os componentes para um perfil')
            ->setHelp('Para garantir acesso para um perfil: singular component:grant-full-access 12')
            ->addArgument(
                'perfil',
                InputArgument::REQUIRED,
                'ID do perfil que terá acesso garantido. Ex.: 12'
            );

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
        $perfil = $input->getArgument('perfil');

        try {
            $app['singular.service.component']->grantFullAccess($perfil);
            $output->writeln(sprintf('<info>Acesso garantido para o perfil %d!</info>',$perfil));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

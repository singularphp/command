<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe do comando de desativação de um pacote.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class DisablePackCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:disable-pack')
            ->setDescription('Desabilita um pacote da aplicação')
            ->setHelp('Para desabilitar um pacote, informe o nome do pacote. Ex.: singular backend:disable-pack Sessao')
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote a ser desativado. Ex.: Sessao'
            );
    }

    /**
     * Executa o comando de desativação do pacote.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $pack = $input->getArgument('pacote');

        try {
            $app['singular.service.pack']->disable($pack);
            $output->writeln(sprintf('<info>Pacote "%s" desativado com sucesso!</info>',$pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

<?php

namespace Singular\Command\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe do comando de ativação de um pacote.
 *
 * @author Otávio Fernandes <otavio@netonsolucoes.com.br>
 */
class EnablePackCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('backend:enable-pack')
            ->setDescription('Habilita um pacote da aplicação')
            ->setHelp('Para habilitar um pacote, informe o nome do pacote. Ex.: singular backend:enable-pack Sessao')
            ->addArgument(
                'pacote',
                InputArgument::REQUIRED,
                'Nome do pacote a ser ativado. Ex.: Sessao'
            );
    }

    /**
     * Executa o comando de ativação do pacote.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $pack = $input->getArgument('pacote');

        try {
            $app['singular.service.pack']->enable($pack);
            $output->writeln(sprintf('<info>Pacote "%s" ativado com sucesso!</info>',$pack));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

    }
}

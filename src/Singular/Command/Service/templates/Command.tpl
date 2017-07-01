<?php

namespace $NAMESPACE\Command;

use Singular\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe do comando.
 *
 * @author $author <$email>
*/
class $COMMANDCommand extends Command
{
    /**
     * Configura o comando.
     */
    public function configure()
    {
        $this->setName('$pack:$command')
            ->setDescription('Descrição do comando')
            ->setHelp('Ajuda para execução do comando')
            ->addArgument(
                'parametro',
                InputArgument::REQUIRED,
                'Descricao do parâmetro'
            );
    }

    /**
     * Executa o comando.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $output->writeln(sprintf('<info>%s</info>', 'Comando executado com sucesso!'));
    }
}

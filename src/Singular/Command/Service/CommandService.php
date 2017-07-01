<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class CommandService
{
    /**
     * Diretório raiz do código da aplicação.
     *
     * @var string
     */
    protected $sourceDir = '';

    /**
     * Serviço de manipulação de pacotes.
     *
     * @var null|PackService
     */
    protected $packService = null;

    /**
     * Define o diretório de código fontes do projeto.
     *
     * @param string $srcDir
     * @param PackService $packService
     */
    public function __construct($srcDir, PackService $packService)
    {
        $this->sourceDir = $srcDir;
        $this->packService = $packService;
    }

    /**
     * Cria o comando em um pacote.
     *
     * @param string $command
     * @param string $pack
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($command, $pack, $author, $email)
    {
        $fs = new Filesystem();

        if (!$this->sourceDir) {
            throw new \Exception('O diretório de código fonte "singular.directory.src" da aplicação não foi definido!');
        }

        $packDir = $this->packService->getPackDir($pack);

        if (!$fs->exists($packDir)) {
            throw new \Exception(sprintf('O pacote %s não existe!', $pack));
        }

        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."Command.tpl"
        );

        $commandClassName = $this->getCommandClassName($command);
        $template = str_replace('$NAMESPACE',ucfirst($pack), $template);
        $template = str_replace('$COMMAND', $commandClassName , $template);
        $template = str_replace('$pack', strtolower($pack) , $template);
        $template = str_replace('$command', $this->fromCamelCase($command), $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        $commandDir = $packDir.DIRECTORY_SEPARATOR.'Command';

        if (!$fs->exists($commandDir)) {
            $fs->mkdir($commandDir);
        }

        file_put_contents($commandDir.DIRECTORY_SEPARATOR.$commandClassName.'Command.php', $template);
    }

    /**
     * Converte uma string CamelCase para snake-case.
     *
     * @param string $input
     *
     * @return string
     */
    private function fromCamelCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('-', $ret);
    }

    /**
     * Retorna o nome da classe do comando.
     *
     * @param string $command
     *
     * @return string
     */
    private function getCommandClassName($command)
    {
        $names = explode('-', $command);
        $className = '';

        foreach ($names as $name) {
            $className.= ucfirst($name);
        }

        return $className;
    }

}

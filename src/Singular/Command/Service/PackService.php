<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class PackService
{
    /**
     * Diretório raiz do código da aplicação.
     *
     * @var string
     */
    protected $sourceDir = '';

    /**
     * Diretório onde são armazenados os pacotes ativados da aplicação.
     *
     * @var string
     */
    protected $packDir = '';

    /**
     * Define o diretório de código fontes do projeto.
     *
     * @param string $srcDir
     * @param string $packDir
     */
    public function __construct($srcDir, $packDir)
    {
        $this->sourceDir = $srcDir;
        $this->packDir = $packDir;
    }

    /**
     * Cria a estrutura de um pacote.
     *
     * @param string $pack
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($pack, $author, $email)
    {
        $fs = new Filesystem();

        if (!$this->sourceDir) {
            throw new \Exception('O diretório de código fonte "singular.directory.src" da aplicação não foi definido!');
        }

        $packDir = $this->getPackDir($pack);

        if ($fs->exists($packDir)) {
            throw new \Exception(sprintf('O pacote %s já foi criado!', $pack));
        }

        $this->createDirectories($packDir);
        $this->createPackServiceProvider($pack, $packDir, $author, $email);
    }

    /**
     * Habilita o pacote.
     *
     * @param string $pack
     *
     * @throws \Exception
     */
    public function enable($pack)
    {
        $fs = new Filesystem();

        if (!$fs->exists($this->getPackDir($pack))) {
            throw new \Exception(sprintf('O pacote "%s" não existe!',$pack));
        }

        $packname = ucfirst($pack);

        $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."packregister.tpl");
        $template = str_replace('$PACK', ucfirst($pack)."\\".$packname, $template);

        file_put_contents($this->packDir.DIRECTORY_SEPARATOR.strtolower($packname).".php", $template);
    }

    /**
     * Desabilita o pacote da aplicação.
     *
     * @param string $pack
     *
     * @throws \Exception
     */
    public function disable($pack)
    {
        $fs = new Filesystem();

        if (!$fs->exists($this->getPackDir($pack))) {
            throw new \Exception(sprintf('O pacote "%s" não existe!',$pack));
        }

        @unlink($this->packDir.DIRECTORY_SEPARATOR.strtolower(ucfirst($pack)).".php");
    }

    /**
     * Recupera o diretório de código de um pacote.
     *
     * @param string $pack
     *
     * @return string
     */
    public function getPackDir($pack)
    {
        return $this->sourceDir.DIRECTORY_SEPARATOR.ucfirst($pack);
    }

    /**
     * Cria o provedor de serviços do pacote.
     *
     * @param string $pack
     * @param string $packDir
     * @param string $author
     * @param string $email
     */
    private function createPackServiceProvider($pack, $packDir, $author, $email)
    {
        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."PackServiceProvider.tpl"
        );

        $template = str_replace('$NAMESPACE',ucfirst($pack), $template);
        $template = str_replace('$PACK', ucfirst($pack), $template);
        $template = str_replace('$name', strtolower($pack), $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($packDir.DIRECTORY_SEPARATOR.ucfirst($pack).'ServiceProvider.php', $template);
    }

    /**
     * Cria os diretórios do pacote.
     *
     * @param string $packDir
     */
    private function createDirectories($packDir)
    {
        $fs = new Filesystem();

        $fs->mkdir($packDir);
        $fs->mkdir($packDir.DIRECTORY_SEPARATOR."Command");
        $fs->mkdir($packDir.DIRECTORY_SEPARATOR."Controller");
        $fs->mkdir($packDir.DIRECTORY_SEPARATOR."Service");
        $fs->mkdir($packDir.DIRECTORY_SEPARATOR."Store");
        $fs->mkdir($packDir.DIRECTORY_SEPARATOR."Model");
    }
}

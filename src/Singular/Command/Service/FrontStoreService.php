<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class FrontStoreService
{
    /**
     * Diretório raiz do código javascript da aplicação.
     *
     * @var string
     */
    protected $jsDir = '';

    /**
     * Define o diretório de código javascript do projeto.
     *
     * @param string $srcDir
     * @param string $packDir
     */
    public function __construct($jsDir)
    {
        $this->jsDir = $jsDir;
    }

    /**
     * Cria a estrutura de um módulo.
     *
     * @param string $name
     * @param string $module
     * @param string $pack
     * @param string $controller
     * @param string $dir
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($name, $module, $pack, $controller, $dir, $author, $email)
    {
        $fs = new Filesystem();

        if (!$this->jsDir) {
            throw new \Exception('O diretório de código javascript "injector.directory.src" da aplicação não foi definido!');
        }

        $moduleDir = $this->getModuleDir($dir);

        if (!$fs->exists($moduleDir)) {
            throw new \Exception(sprintf('O módulo %s não existe!', $module));
        }

        $storeFile = $this->getStoreFile($name, $moduleDir);

        if ($fs->exists($storeFile)) {
            throw new \Exception(sprintf('O store %s já existe!', $name));
        }

        $this->createStore($name, $storeFile, $module, $pack, $controller, $author, $email);
    }

    /**
     * Recupera o diretório de código de um módulo.
     *
     * @param string $module
     *
     * @return string
     */
    private function getModuleDir($dir)
    {
        return $this->jsDir.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
    }

    /**
     * Recupera o nome do script do controlador.
     *
     * @param string $name
     * @param string $moduleDir
     *
     * @return string
     */
    private function getStoreFile($name, $moduleDir)
    {
        return $moduleDir.DIRECTORY_SEPARATOR."services".DIRECTORY_SEPARATOR.$name."Store";
    }

    /**
     * Cria o script do controlador de frontend.
     *
     * @param string $name
     * @param string $storeFile
     * @param string $module
     * @param string $author
     * @param string $email
     */
    private function createStore($name, $storeFile, $module, $pack, $controller, $author, $email)
    {
        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."front_store.tpl"
        );

        $template = str_replace('$name', $name, $template);
        $template = str_replace('$PACK', $pack, $template);
        $template = str_replace('$CONTROLLER', $controller, $template);
        $template = str_replace('$module',$module, $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($storeFile.'.js', $template);
    }
}

<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class FrontControllerService
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
     * @param string $dir
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($name, $module, $dir, $author, $email)
    {
        $fs = new Filesystem();

        if (!$this->jsDir) {
            throw new \Exception('O diretório de código javascript "injector.directory.src" da aplicação não foi definido!');
        }

        $moduleDir = $this->getControllerDir($dir);

        if (!$fs->exists($moduleDir)) {
            throw new \Exception(sprintf('O módulo %s não existe!', $module));
        }

        $controllerFile = $this->getControllerFile($name, $moduleDir);

        if ($fs->exists($controllerFile)) {
            throw new \Exception(sprintf('O controlador %s já existe!', $name));
        }

        $this->createController($name, $controllerFile, $module, $author, $email);
    }

    /**
     * Recupera o diretório de código de um módulo.
     *
     * @param string $module
     *
     * @return string
     */
    private function getControllerDir($dir)
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
    private function getControllerFile($name, $moduleDir)
    {
        return $moduleDir.DIRECTORY_SEPARATOR."controllers".DIRECTORY_SEPARATOR.$name;
    }

    /**
     * Cria o script do controlador de frontend.
     *
     * @param string $name
     * @param string $controllerFile
     * @param string $module
     * @param string $author
     * @param string $email
     */
    private function createController($name, $controllerFile, $module, $author, $email)
    {
        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."front_controller.tpl"
        );

        $template = str_replace('$name', $name, $template);
        $template = str_replace('$module',$module, $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($controllerFile.'.js', $template);
    }

    /**
     * Recupera o nome do arquivo do módulo.
     *
     * @param string $module
     *
     * @return string
     */
    private function getModuleFileName($module)
    {
        list($namespace, $script) = explode('.', $module);

        return $script;
    }
}

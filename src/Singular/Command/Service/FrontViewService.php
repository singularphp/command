<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class FrontViewService
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
     * Cria uma view.
     *
     * @param string $view
     * @param string $dir
     * @param string $type
     * 
     * @throws \Exception
     */
    public function create($view, $dir, $type)
    {
        $fs = new Filesystem();

        if (!$this->jsDir) {
            throw new \Exception('O diretório de código javascript "injector.directory.src" da aplicação não foi definido!');
        }

        $moduleDir = $this->getModuleDir($dir);

        if (!$fs->exists($moduleDir)) {
            throw new \Exception(sprintf('O diretório do módulo não existe!'));
        }

        $viewFile = $this->getViewFile($view, $moduleDir, $type);

        if ($fs->exists($viewFile)) {
            throw new \Exception(sprintf('A view %s já existe!', $viewFile));
        }

        if (!in_array($type, ['list','form','modal','filter','tab'])){
            throw new \Exception(sprintf('O tipo de view %s não existe!',$type));
        }

        $this->createView($view, $viewFile, $type, $moduleDir);
    }

    /**
     * Recupera o diretório de código de um módulo.
     *
     * @param string $dir
     *
     * @return string
     */
    private function getModuleDir($dir)
    {
        return $this->jsDir.DIRECTORY_SEPARATOR.$dir;
    }

    /**
     * Recupera o nome do script do controlador.
     *
     * @param string $view
     * @param string $moduleDir
     * @param string $type
     *
     * @return string
     */
    private function getViewFile($view, $moduleDir, $type)
    {
        return $moduleDir.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$view.".".$type.".html";
    }

    /**
     * Cria o template da view.
     *
     * @param string $view
     * @param string $viewFile
     * @param string $type
     * @param string $moduleDir
     */
    private function createView($view, $viewFile, $type, $moduleDir)
    {
//        $viewDir = str_replace($this->jsDir, '', $moduleDir.DIRECTORY_SEPARATOR."views");

        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."view_".$type.".tpl"
        );

//        $template = str_replace('$viewDir', $viewDir, $template);
        $template = str_replace('$view', $view, $template);

        file_put_contents($viewFile, $template);
    }
}

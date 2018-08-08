<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class ModuleService
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
     * @param string $module
     * @param string $dir
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($module, $dir, $author, $email)
    {
        $fs = new Filesystem();

        if (!$this->jsDir) {
            throw new \Exception('O diretório de código javascript "injector.directory.src" da aplicação não foi definido!');
        }

        $moduleDir = $this->getModuleDir($module, $dir);

        if ($fs->exists($moduleDir)) {
            throw new \Exception(sprintf('O módulo %s já foi criado!', $module));
        }

        $this->createDirectories($moduleDir, $module);
        $this->createModule($module, $moduleDir, $dir, $author, $email);

        return $moduleDir;
    }

    /**
     * Recupera o diretório de código de um módulo.
     *
     * @param string $module
     * @param string $dir
     *
     * @return string
     */
    public function getModuleDir($module, $dir)
    {
        return $this->jsDir.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$this->getModuleFileName($module);
    }

    /**
     * @param $module
     * @param $moduleDir
     * @param $author
     * @param $email
     */
    private function createModule($module, $moduleDir, $dir, $author, $email)
    {
        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."module.tpl"
        );

        $file = $this->getModuleFileName($module);

        $template = str_replace('$moduleDir', $dir.DIRECTORY_SEPARATOR.$file, $template);
        $template = str_replace('$module',$module, $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($moduleDir.DIRECTORY_SEPARATOR.$file.'.js', $template);

        $this->registerModule($module, $dir);
    }

    /**
     * Registra o módulo criado no módulo pai.
     *
     * @param string $module
     * @param string $dir
     */
    private function registerModule($module, $dir)
    {
        $parentModuleFile = $this->jsDir.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$this->getParentModuleFile($dir).".js";

        if (!file_exists($parentModuleFile)) {
            return;
        }
        
        $fileContent = file_get_contents($parentModuleFile);

        $fileContent = str_replace('/*@modules*/', ",'".$module."'\n            /*@modules*/", $fileContent);

        file_put_contents($parentModuleFile, $fileContent);
    }

    /**
     * Recupera o nome do script do módulo pai.
     *
     * @param string $parentDir
     *
     * @return string
     */
    private function getParentModuleFile($parentDir)
    {
        $paths = explode(DIRECTORY_SEPARATOR, $parentDir);

        return end($paths);
    }

    /**
     * Cria os diretórios do pacote.
     *
     * @param string $moduleDir
     * @param string $module
     */
    private function createDirectories($moduleDir, $module)
    {
        $fs = new Filesystem();

        $fs->mkdir($moduleDir);
        $fs->mkdir($moduleDir.DIRECTORY_SEPARATOR."controllers");
        $fs->mkdir($moduleDir.DIRECTORY_SEPARATOR."services");
        $fs->mkdir($moduleDir.DIRECTORY_SEPARATOR."views");
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
        $parts = explode('.', $module);

        if (count($parts) > 1) {
            return $parts[1];
        }

        return $module;
    }
}

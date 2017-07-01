<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;

class ControllerService
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
     * Cria o controlador no pacote.
     *
     * @param string $controller
     * @param string $pack
     * @param string $author
     * @param string $email
     * @param boolean $crud
     *
     * @throws \Exception
     */
    public function create($controller, $pack, $author, $email, $crud)
    {
        $fs = new Filesystem();

        if (!$this->sourceDir) {
            throw new \Exception('O diretório de código fonte "singular.directory.src" da aplicação não foi definido!');
        }

        $packDir = $this->packService->getPackDir($pack);

        if (!$fs->exists($packDir)) {
            throw new \Exception(sprintf('O pacote %s não existe!', $pack));
        }

        $templateFile = 'Controller';

        if ($crud) {
            $templateFile = 'CrudController';
        }

        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$templateFile.".tpl"
        );

        $template = str_replace('$NAMESPACE',ucfirst($pack), $template);
        $template = str_replace('$CONTROLLER', $controller , $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($packDir.DIRECTORY_SEPARATOR.'Controller'.DIRECTORY_SEPARATOR.$controller.'.php', $template);

    }
}

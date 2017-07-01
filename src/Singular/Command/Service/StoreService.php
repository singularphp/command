<?php

namespace Singular\Command\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class StoreService
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
     * Cria um serviço no pacote.
     *
     * @param string $store
     * @param string $pack
     * @param string $model
     * @param string $author
     * @param string $email
     *
     * @throws \Exception
     */
    public function create($store, $pack, $model, $author, $email)
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
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."Store.tpl"
        );

        $template = str_replace('$NAMESPACE',ucfirst($pack), $template);
        $template = str_replace('$STORE', $store , $template);
        $template = str_replace('$$model', ucfirst($pack)."\\Model\\".$model , $template);
        $template = str_replace('$author', $author, $template);
        $template = str_replace('$email', $email, $template);

        file_put_contents($packDir.DIRECTORY_SEPARATOR.'Store'.DIRECTORY_SEPARATOR.$store.'.php', $template);

    }
}

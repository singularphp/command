<?php

namespace Singular\Command\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class ComponentService
{
    /**
     * Diretório raiz do código da aplicação.
     *
     * @var string
     */
    protected $sourceDir = '';

    /**
     * Conexão com o banco de dados.
     *
     * @var Connection
     */
    protected $db = null;

    /**
     * Define o diretório de código fontes do projeto.
     *
     * @param string $srcDir
     * @param Connection $db
     */
    public function __construct($srcDir, $db)
    {
        $this->sourceDir = $srcDir;
        $this->db = $db;
    }

    /**
     * Cria o comando em um pacote.
     *
     * @throws \Exception
     */
    public function create()
    {
        $fs = new Filesystem();

        if (!$this->sourceDir) {
            throw new \Exception('O diretório de código fonte "singular.directory.src" da aplicação não foi definido!');
        }

        $migrationDir = $this->getMigrationDir();

        if (!$fs->exists($migrationDir)) {
            throw new \Exception(sprintf('O diretório de migration não existe!'));
        }

        $template = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."migration.tpl"
        );

        $date = date('Ymdhis');
        $timestamp = time();

        $components = $this->getComponentsToMigration();

        $template = str_replace('$TIMESTAMP',$timestamp, $template);
        $template = str_replace('$COMPONENTS', $this->arrayToString($components, $timestamp) , $template);

        $this->clear();

        file_put_contents($migrationDir.DIRECTORY_SEPARATOR.$date.'_insere_registros_componentes_'.$timestamp.'.php', $template);

        return count($components);
    }

    /**
     * Converte um array para uma representação do array em string.
     *
     * @param array $array
     * @param string $timestamp
     *
     * @return string
     */
    private function arrayToString($array, $timestamp)
    {
        $string = [];

        foreach ($array as $component) {
            $item = [];
            foreach ($component as $key => $value) {
                if ($key == 'migration') {
                    $value = $timestamp;
                }

                if ($key == 'menu_id' && $value == "") {
                    $value = null;
                }

                if ($value != null){
                    $item[] = '"'.$key.'" => "'.$value.'"';
                } else {
                    $item[] = '"'.$key.'" => null';
                }

            }

            $string[] = "[".implode(",", $item)."]\n";
        }

        return "[\n            ".implode("            ,", $string)."        ]";
    }

    /**
     * Recupera a relação de componentes que farão parte da migrations.
     *
     * @return array
     */
    private function getComponentsToMigration()
    {
        $db = $this->db;

        $components = $db->fetchAll('SELECT * FROM singular_componente WHERE migration IS NULL');

        return $components;
    }

    /**
     * Recupera a relação de componentes que farão parte da migrations.
     *
     * @return array
     */
    private function clear()
    {
        $db = $this->db;

        $db->executeQuery('DELETE FROM singular_componente WHERE migration IS NULL');
    }

    /**
     * Retorna o nome da classe do comando.
     *
     * @return string
     */
    private function getMigrationDir()
    {
        return $this->sourceDir.DIRECTORY_SEPARATOR."db".DIRECTORY_SEPARATOR."migrations";
    }

}

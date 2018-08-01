<?php

namespace Singular\Command\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class MenuService
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

        $timestamp = time();

        $aplicacoes = $this->getAplicacoesToMigration();

        if (count($aplicacoes) > 0) {
            $template = file_get_contents(
                __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."app_migration.tpl"
            );

            $template = str_replace('$TIMESTAMP',$timestamp, $template);
            $template = str_replace('$APLICACOES', $this->arrayToString($aplicacoes, $timestamp) , $template);

            $dt = new \DateTime('now', new \DateTimeZone('UTC'));
            $date = $dt->format('YmdHis');

            file_put_contents($migrationDir.DIRECTORY_SEPARATOR.$date.'_insere_registros_aplicacoes_'.$timestamp.'.php', $template);
        }

        $modulos = $this->getModulosToMigration();

        if (count($modulos) > 0) {
            $template = file_get_contents(
                __DIR__.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR."mod_migration.tpl"
            );

            $template = str_replace('$TIMESTAMP',$timestamp, $template);
            $template = str_replace('$MODULOS', $this->arrayToString($modulos, $timestamp) , $template);

            sleep(1);

            $dt = new \DateTime('now', new \DateTimeZone('UTC'));
            $date = $dt->format('YmdHis');

            file_put_contents($migrationDir.DIRECTORY_SEPARATOR.$date.'_insere_registros_modulos_'.$timestamp.'.php', $template);
        }

        $this->clearMigrations();

        return count($modulos) + count($aplicacoes);
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
     * Recupera a relação de módulos que farão parte da migration.
     *
     * @return array
     */
    private function getAplicacoesToMigration()
    {
        $db = $this->db;

        $aplicacoes = $db->fetchAll('SELECT * FROM singular_aplicacao WHERE migration IS NULL');

        return $aplicacoes;
    }

    /**
     * Recupera a relação de módulos que farão parte da migration.
     *
     * @return array
     */
    private function getModulosToMigration()
    {
        $db = $this->db;

        $modulos = $db->fetchAll('SELECT * FROM singular_modulo WHERE migration IS NULL');

        return $modulos;
    }

    /**
     * Recupera a relação de aplicações e módulos que farão parte da migrations.
     *
     * @return array
     */
    private function clearMigrations()
    {
        $db = $this->db;

        $db->executeQuery('DELETE FROM singular_aplicacao WHERE migration IS NULL');
        $db->executeQuery('DELETE FROM singular_modulo WHERE migration IS NULL');
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

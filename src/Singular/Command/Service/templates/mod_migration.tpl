<?php

use Phinx\Migration\AbstractMigration;

class InsereRegistrosModulos$TIMESTAMP extends AbstractMigration
{
    /**
     * Insere os registros no banco.
     */
    public function up()
    {

        $modulos = $MODULOS;

        $this->insert('singular_modulo', $modulos);
    }

    /**
     * Excluí os registros do banco.
     */
    public function down()
    {
        $this->execute('DELETE FROM singular_modulo WHERE migration = "$TIMESTAMP"');
    }
}

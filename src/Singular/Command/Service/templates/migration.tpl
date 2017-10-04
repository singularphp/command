<?php

use Phinx\Migration\AbstractMigration;

class InsereRegistrosComponentes$TIMESTAMP extends AbstractMigration
{
    /**
     * Insere os registros no banco.
     */
    public function up()
    {

        $comonentes = $COMPONENTS;

        $this->insert('singular_componente', $comonentes);
    }

    /**
     * Excluí os registros do banco.
     */
    public function down()
    {
        $this->execute('DELETE FROM singular_componente WHERE migration = "$TIMESTAMP"');
    }
}

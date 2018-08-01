<?php

use Phinx\Migration\AbstractMigration;

class InsereRegistrosAplicacoes$TIMESTAMP extends AbstractMigration
{
    /**
     * Insere os registros no banco.
     */
    public function up()
    {

        $aplicacoes = $APLICACOES;

        $this->insert('singular_aplicacao', $aplicacoes);
    }

    /**
     * Excluí os registros do banco.
     */
    public function down()
    {
        $this->execute('DELETE FROM singular_aplicacao WHERE migration = "$TIMESTAMP"');
    }
}

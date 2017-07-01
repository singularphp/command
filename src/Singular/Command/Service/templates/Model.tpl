<?php
namespace $NAMESPACE\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe $MODEL
 *
 * @author $author <$email>
 */
class $MODEL extends Model
{
    /**
     * A tabela associada ao modelo
     *
     * @var string
     */
    protected $table = '$$table';

    /**
     * Lista dos campos que não podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Não utiliza os campos de data e hora de criação/atualização.
     *
     * @var array
     */
    public $timestamps = false;
}
<?php

namespace Sessao\Store;

use Singular\SingularStore;
use Singular\Annotation\Service;
use Singular\Annotation\Parameter;


/**
 * Classe $STORE
 *
 * @Service
 *
 * @author $author <$email>
 */
class $STORE extends SingularStore
{
    /**
     * Tabela relacionada no banco de dados.
     *
     * @var string
     */
    protected $table = '$TABLE';

    /**
     * Perfis de consulta.
     *
     * @var array
     */
    protected $profiles = [
        'default' => [
            'select' => ['t.*'],
            'joins' => [],
            'filters' => [],
            'groupings' => []
        ]
    ];
}
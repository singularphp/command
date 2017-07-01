<?php
namespace $NAMESPACE\Store;

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
     * Classe do modelo vinculado ao store.
     *
     * @var string
     */
    protected $modelClass = '$model';
}
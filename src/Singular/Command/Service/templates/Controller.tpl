<?php
namespace $NAMESPACE\Controller;

use Symfony\Component\HttpFoundation\Request;
use Singular\SingularController;
use Singular\Annotation\Controller;
use Singular\Annotation\Route;
use Singular\Annotation\Direct;
use Singular\Annotation\Value;
use Singular\Annotation\Assert;
use Singular\Annotation\Convert;
use Singular\Annotation\After;
use Singular\Annotation\Before;

/**
 * Classe $CONTROLLER
 *
 * @Controller
 *
 * @author $author <$email>
 */
class $CONTROLLER extends SingularController
{
    /**
     * Defina o store padrão do controlador.
     *
     * @var $store
     */
    protected $store = '';
}
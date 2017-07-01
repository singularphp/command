<?php
namespace $NAMESPACE;

use Singular\Provider\PackServiceProvider;
use Pimple\Container;
use Silex\Application;

/**
 * Provedor de serviços do pacote $PACK.
 *
 * @author $author <$email>
 */
class $PACKServiceProvider extends PackServiceProvider
{
    /**
     * Nome do pacote.
     *
     * @var string
     */
    protected $pack = '$name';

    /**
     * Registra serviços e parâmetros do pacote.
     *
     * @param Container $app
     */
    public function register(Container $app)
    {
    }

    /**
     * Define controladores como serviços e mapeia rotas do pacote.
     *
     * @param Application $app
     */
    public function connect(Application $app)
    {
    }

    /**
     * Executa ações durante o boot da aplicação.
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}

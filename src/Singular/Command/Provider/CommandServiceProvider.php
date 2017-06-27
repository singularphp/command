<?php
namespace Singular\Command\Provider;


use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Singular\Command\Command\CreatePackCommand;

class CommandServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * Registra os serviços do provedor.
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['singular.command.create_pack'] = function(){
            new CreatePackCommand();
        };
    }

    /**
     * Adiciona os comandos ao console da aplicação.
     *
     * @throws \Exception
     * @param Application $app
     */
    public function boot(Application $app)
    {
        if (!$app['console']) {
            throw new \Exception('O provedor de serviços singular/console não foi registrado na aplicação!');
        }

        $app['console']->add($app['singular.command.create_pack']);
    }
}
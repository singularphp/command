<?php

namespace Singular\Command\Provider;

use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Singular\Command\Command\CreateCommandCommand;
use Singular\Command\Command\CreateComponentMigrationCommand;
use Singular\Command\Command\CreateControllerCommand;
use Singular\Command\Command\CreatePackCommand;
use Singular\Command\Command\CreateServiceCommand;
use Singular\Command\Command\CreateStoreCommand;
use Singular\Command\Command\DisablePackCommand;
use Singular\Command\Command\EnablePackCommand;
use Singular\Command\Service\CommandService;
use Singular\Command\Service\ControllerService;
use Singular\Command\Service\PackService;
use Singular\Command\Service\ServiceService;
use Singular\Command\Service\StoreService;
use Singular\Command\Service\ModuleService;
use Singular\Command\Command\CreateModuleCommand;
use Singular\Command\Command\CreateFrontControllerCommand;
use Singular\Command\Service\FrontControllerService;
use Singular\Command\Command\CreateFrontViewCommand;
use Singular\Command\Service\FrontViewService;
use Singular\Command\Service\ComponentService;

class CommandServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * Registra os serviços do provedor.
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['singular.service.pack'] = function () use ($pimple) {
            return new PackService(
                $pimple['singular.directory.src'],
                $pimple['singular.directory.app'].DIRECTORY_SEPARATOR."packs"
            );
        };

        $pimple['singular.service.command'] = function() use ($pimple) {
            return new CommandService(
                $pimple['singular.directory.src'],
                $pimple['singular.service.pack']
            );
        };
        
        $pimple['singular.service.service'] = function() use ($pimple) {
            return new ServiceService(
                $pimple['singular.directory.src'],
                $pimple['singular.service.pack']
            );
        };

        $pimple['singular.service.store'] = function() use ($pimple) {
            return new StoreService(
                $pimple['singular.directory.src'],
                $pimple['singular.service.pack']
            );
        };

        $pimple['singular.service.controller'] = function() use ($pimple) {
            return new ControllerService(
                $pimple['singular.directory.src'],
                $pimple['singular.service.pack']
            );
        };

        $pimple['singular.service.module'] = function() use ($pimple) {
            return new ModuleService(
                $pimple['injector.directory.src']
            );
        };

        $pimple['singular.service.front_controller'] = function() use ($pimple) {
            return new FrontControllerService(
                $pimple['injector.directory.src']
            );
        };

        $pimple['singular.service.front_view'] = function() use ($pimple) {
            return new FrontViewService(
                $pimple['injector.directory.src']
            );
        };

        $pimple['singular.service.create_component_migration'] = function() use ($pimple) {
            return new ComponentService(
                $pimple['singular.directory.root'],
                $pimple['db']
            );
        };

        $pimple['singular.command.create_pack'] = function () {
            return new CreatePackCommand();
        };
        
        $pimple['singular.command.disable_pack'] = function () {
            return new DisablePackCommand();
        };

        $pimple['singular.command.enable_pack'] = function () {
            return new EnablePackCommand();
        };

        $pimple['singular.command.create_command'] = function () {
            return new CreateCommandCommand();
        };

        $pimple['singular.command.create_service'] = function () {
            return new CreateServiceCommand();
        };

        $pimple['singular.command.create_controller'] = function () {
            return new CreateControllerCommand();
        };

        $pimple['singular.command.create_store'] = function () {
            return new CreateStoreCommand();
        };

        $pimple['singular.command.create_module'] = function () {
            return new CreateModuleCommand();
        };

        $pimple['singular.command.create_front_controller'] = function () {
            return new CreateFrontControllerCommand();
        };

        $pimple['singular.command.create_front_view'] = function () {
            return new CreateFrontViewCommand();
        };

        $pimple['singular.command.create_component_migration'] = function () {
            return new CreateComponentMigrationCommand();
        };
    }

    /**
     * Adiciona os comandos ao console da aplicação.
     *
     * @throws \Exception
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        if (!$app['console']) {
            throw new \Exception('O provedor de serviços singular/console não foi registrado na aplicação!');
        }

        $app['console']->add($app['singular.command.create_pack']);
        $app['console']->add($app['singular.command.enable_pack']);
        $app['console']->add($app['singular.command.disable_pack']);
        $app['console']->add($app['singular.command.create_command']);
        $app['console']->add($app['singular.command.create_service']);
        $app['console']->add($app['singular.command.create_controller']);
        $app['console']->add($app['singular.command.create_store']);
        $app['console']->add($app['singular.command.create_module']);
        $app['console']->add($app['singular.command.create_front_controller']);
        $app['console']->add($app['singular.command.create_front_view']);
        $app['console']->add($app['singular.command.create_component_migration']);
    }
}

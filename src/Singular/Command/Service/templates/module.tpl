(function()
{
    'use strict';

    /**
     * Módulo de frontend.
     *
     * @author $author <$email>
     */
    angular.module('$module', [
        /*@modules*/
    ])
        .config(
            [
                '$stateProvider',
                configFn
            ]
        );

    /**
     * Definição da função de configuração do módulo.
     *
     * @param {$stateProvider} $stateProvider
     */
    function configFn(
        $stateProvider
    ){
        /* $stateProvider.state('', {
            url: '',
            controller: '',
            templateUrl: getView('')
        })
        ;*/
    }

    /**
     * Retorna o caminho completo de uma view.
     *
     * @param view
     * @returns {string}
     */
    function getView(view) {
        return 'src/$moduleDir/views/' + view + '.html';
    }

}());
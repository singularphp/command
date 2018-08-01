(function()
{
    'use strict';

    /**
     * Controlador responsável por funcionalidade da aplicação.
     *
     * @author $author <$email>
     */
    angular.module('$module').controller(
        '$name',
        [
            '$scope'
            ,'$state'
            ,'$uibModal'
            ,'SweetAlert'
            ,'toaster'
            ,'$sngApi'
            ,Controller
        ]
    );

    /**
     * Função de definição do controlador.
     *
     * @param $scope
     * @param $state
     * @param $modal
     * @param SweetAlert
     * @param toaster
     * @param $sngApi
     * @constructor
     */
    function Controller(
         $scope
        ,$state
        ,$modal
        ,SweetAlert
        ,toaster
        ,$sngApi
    ) {
        /**
         * Inicialização do controlador.
         */
        $scope.onInit = function(){

        }

        $scope.onInit();
    }

}());
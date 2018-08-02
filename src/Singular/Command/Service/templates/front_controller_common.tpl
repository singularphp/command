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
            ,'toastr'
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
     * @param toastr
     * @param $sngApi
     * @constructor
     */
    function Controller(
         $scope
        ,$state
        ,$modal
        ,SweetAlert
        ,toastr
        ,$sngApi
    ) {
        /**
         * Inicialização do controlador.
         */
        $scope.onInit = function(){

        };

        $scope.onInit();
    }

}());
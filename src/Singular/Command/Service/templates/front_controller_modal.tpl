(function()
{
    'use strict';

    /**
     * Controlador responsável por funcionalidade de listagem.
     *
     * @author $author <$email>
     */
    angular.module('$module').controller(
        '$name',
        [
             '$scope'
            ,'$uibModalInstance'
            ,'toaster'
            ,'$sngApi'
            ,Controller
        ]
    );

    /**
     * Função de definição do controlador.
     *
     * @param $scope
     * @param $uibModalInstance
     * @param toaster
     * @param $sngApi
     * @constructor
     */
    function Controller(
         $scope
        ,$uibModalInstance
        ,toaster
        ,$sngApi
    ) {
        /**
         * Api de comunicação com o controlador no backend.
         *
         * @todo Alterar o valor do pacote/controlador
         * @type {$sngApi}
         */
        $scope.api = $sngApi('pacote/controlador');

        /**
         * Inicialização do controlador.
         */
        $scope.onInit = function(){
            $scope.reloadData();
        };

        /*
         * Fecha o modal em modo de cancelamento
         */
        $scope.cancel = function(){
            $uibModalInstance.dismiss();
        };

        /**
         * Fecha o modal ao encerrar.
         */
        $scope.close = function(){
            $uibModalInstance.close();
        };

        $scope.onInit();
    }

}());
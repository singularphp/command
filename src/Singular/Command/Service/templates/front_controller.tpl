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
            '$scope',
            '$state',
            '$modal',
            '$localStorage',
            'SweetAlert',
            'toaster',
            Controller
        ]
    );

    /**
     * Função de definição do controlador.
     *
     * @param $scope
     * @param $state
     * @param $modal
     * @param $localStorage
     * @param SweetAlert
     * @param toaster
     * @constructor
     */
    function Controller(
        $scope,
        $state,
        $modal,
        $localStorage,
        SweetAlert,
        toaster
    ) {


    }

}());
(function()
{
    'use strict';

    /**
     * Controlador responsável por formulário de criação/edição.
     *
     * @author $author <$email>
     */
    angular.module('$module').controller(
        '$name',
        [
             '$scope'
            ,'$state'
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
     * @param toastr
     * @param $sngApi
     * @constructor
     */
    function Controller(
         $scope
        ,$state
        ,toastr
        ,$sngApi
    ) {
        /**
         * Define que o formulário está em estado de visualização.
         *
         * @todo Alterar o valor do view state
         * @type {string}
         */
        $scope.viewState = 'show';

        /**
         * Se o registro foi encontrado.
         *
         * @type {boolean}
         */
        $scope.hasRecord = true;

        /**
         * Define que o formulário foi submetido.
         *
         * @type {boolean}
         */
        $scope.isSubmited = false;

        /**
         * Define que o formulário está em processo de salvamento.
         *
         * @type {boolean}
         */
        $scope.isSaving = false;

        /**
         * Referência ao registro em edição.
         *
         * @type {Object}
         */
        $scope.record = {};

        /**
         * Referência ao formulário da view.
         *
         * @type {Object}
         */
        $scope.forms = {
            form: {}
        };

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
            $scope.getRecord($stateParams.id);
        };

        /**
         * Salva o registro no backend.
         *
         * @todo Alterar mensagens do toastr.
         */
        $scope.save = function() {
            $scope.isSubmited = true;

            if (!$scope.forms.form.$invalid) {
                $scope.isSaving = true;

                $scope.api.save($scope.record).then(function(response){
                    if (response.success) {
                        $scope.isSaving = false;
                        
                        toastr.success('Registro criado/atualizado com sucesso!');

                        $state.go('',{});
                    } else {
                        toastr.error('Falhou ao criar/atualizar o registro!');
                    }
                });
            } else {
                toastr.error('Verifique o preenchimento do formulário!');
            }
        };

        /**
         * Carrega um registro na Api pelo seu id.
         *
         * @param {int} id
         */
        $scope.getRecord = function(id) {
            $scope.hasRecord = false;

            $scope.api.get(id).then(function(record){
                if (record) {
                    $scope.hasRecord = true;
                }

                $scope.record = record;
            });
        };

        $scope.onInit();
    }

}());
(function()
{
   /**
    * Serviço de store.
    *
    * @author $author <$email>
    */
    angular.module('$module').factory(
        '$nameStore',
        [
            'ui.StoreFactory',
            Service
        ]
    );

    /**
     * Função de definição do serviço.
     *
     * @param StoreFactory
     * @returns {Service}
     * @constructor
     */
    function Service(
        StoreFactory
    ) {
        var me = StoreFactory.create('$PACK', '$CONTROLLER');

        /**
         * Mapa do filtro de consultas.
         *
         * @type {Object}
         * @example {
         *    id: '=',
         *    status: {
         *       property: 'en.status',
         *       operation: '=',
         *       convert: function(v){
         *          if (v > 1) {
         *              return 1;
         *          }
         *       }
         *    }
         * }
         */
        me.filterMap = {
        };

        /**
         * Habilita ou desabilita a seleção de linhas na md-table.
         *
         * @bool
         */
        me.enableRowSelection = false;


        return me;
    }
}());
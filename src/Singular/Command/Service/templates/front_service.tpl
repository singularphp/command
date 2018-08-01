(function()
{
   /**
    * Serviço de interface.
    *
    * @author $author <$email>
    */
    angular.module('$module').factory(
        '$nameService',
        [
            '$sngApi',
            Service
        ]
    );

    /**
     * Função de definição do serviço.
     *
     * @param $sngApi
     * @returns {Service}
     * @constructor
     */
    function Service(
        $sngApi
    ) {
        var me = this;

        return me;
    }
}());
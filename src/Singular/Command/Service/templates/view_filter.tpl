<sng-page class="panel-default">
    <div class="modal-header panel-heading p-t-xs p-b-xs">
        <h4>
            <i class="fa fa-filter"></i>&nbsp;Filtrar resultados
            <i class="fa fa-times pull-right" ng-click="close()"></i>
        </h4>
    </div>
    <sng-content>
        <div class="row wrapper-md">
            <div class="form-group col-sm-12">
                <label class="control-label label-sm" for="filtro">Filtro </label>
                <div class="input-group">
                    <input class="form-control" type="text" autofocus placeholder="Filtro contém" ng-model="filter.filtro" id="filtro" name="filtro">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-icon" type="button" ng-click="clear('filtro')" ng-disabled="!filter.filtro.length"><i class="fa fa-times"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </sng-content>
    <div class="modal-footer p-t-none p-b-sm">
        <button class="btn m-t-sm pull-left text-info" ng-click="clear()">Limpar filtro</button>
        <button class="btn m-t-sm btn-info pull-right" type="submit" ng-click="apply()"><i class="fa fa-check pull-left"></i> Aplicar filtro</button>
    </div>
</sng-page>


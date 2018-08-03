<sng-page>
    <sng-header>
        <div class="font-normal h3 pull-left m-t-xs col-sm-6">
            <i class="fa fa-users"></i>
            <span ng-if="viewState == 'create'"> Novo</span>
            <span ng-if="viewState == 'edit'"> Editando</span>
            <span ng-if="viewState == 'show'"> Visualizando</span>
        </div>

        <div class="col-sm-6 pull-right">
            <button type="button" class="btn btn-success btn-addon pull-right" ng-click="save()" ng-if="viewState != 'show'" ng-disabled="isSaving">
                <i class="fa fa-check" ></i>
                <span ng-if="!isSaving">Salvar</span>
                <span ng-if="isSaving">Salvando...</span>
            </button>

            <button type="button" class="btn btn-info btn-addon pull-right m-r-xs" ng-if="viewState == 'show'" ui-sref="app.$VIEW-edit({id: record.id})">
                <i class="fa fa-edit"></i> Editar
            </button>

            <button type="button" class="btn btn-default btn-addon pull-right m-r-xs" ui-sref="app.$VIEW-list">
                <i class="fa fa-times"></i> Cancelar
            </button>
        </div>
    </sng-header>
    <sng-content>
        <div class="wrapper-md">
            <div class="row">
                <div class="col-sm-12">
                    <uib-tabset justified="true" class="tab-container" ng-if="hasRecord">
                        <uib-tab heading="">
                            <div ng-include="''"></div>
                        </uib-tab>
                    </uib-tabset>
                    <sng-empty-state ng-if="!hasRecord">
                        <h3><i class="fa fa-frown-o"></i> Ops, registro não localizado!</h3>
                        <button type="button" class="btn btn-default btn-addon" ui-sref="app.$VIEW-list">
                            <i class="fa fa-undo"></i> Voltar
                        </button>
                    </sng-empty-state>
                </div>
            </div>
        </div>
    </sng-content>
</sng-page>
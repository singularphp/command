<div class="hbox hbox-auto-xs" >
    <div class="col lter b-l">

        <div class="vbox">
            <!-- Start:Toolbar -->
            <div class="wrapper-sm bg-light lter b-b clearfix">
                <div class="font-normal h3 pull-left m-t-xs col-sm-6">
                    <i class="fa fa-clipboard"></i>
                    <span ng-if="isCreate"> Novo </span>
                    <span ng-if="isEdit"> Editando </span>
                    <span ng-if="isShow"> Visualizando </span>
                </div>

                <div class="col-sm-6 pull-right">
                    <button type="button" class="btn btn-success btn-addon pull-right" ng-click="save()" ng-if="!isShow" ng-disabled="isSaving">
                        <i class="fa fa-check" ></i>
                        <span ng-if="!isSaving">Salvar</span>
                        <span ng-if="isSaving">Salvando...</span>
                    </button>

                    <button type="button" class="btn btn-info btn-addon pull-right m-r-xs" ng-if="isShow" ui-sref="app.$VIEW-edit({id: $VIEW.id})">
                        <i class="fa fa-edit"></i> Editar
                    </button>

                    <button type="button" class="btn btn-default btn-addon pull-right m-r-xs" ui-sref="app.$VIEW-list">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
            <!-- End:Toolbar -->
            <div class="row-row">
                <div class="cell">
                    <div class="cell-inner">
                        <!-- Start:Content-->
                        <div class="wrapper-md">
                            <div class="row">
                                <div class="col-sm-12">
                                    <tabset justified="true" class="tab-container" ng-if="hasRecord">
                                        <tab heading="">
                                            <div ng-include="'#'"></div>
                                        </tab>
                                    </tabset>
                                    <div class="panel panel-default clearfix ng-scope" ng-if="!hasRecord" style="">
                                        <div class="wrapper-md row"></div>
                                        <div class="col-sm-12 text-center m-b-lg">
                                            <h3><i class="fa fa-frown-o"></i> Ops, registro não localizado!</h3>
                                            <button type="button" class="btn btn-default btn-addon" ui-sref="app.$VIEW-list">
                                                <i class="fa fa-undo"></i> Voltar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End:Content-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
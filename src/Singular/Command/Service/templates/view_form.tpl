<div class="hbox hbox-auto-xs" >
    <div class="col lter b-l">

        <div class="vbox">
            <!-- Start:Toolbar -->
            <div class="wrapper-sm bg-light lter b-b clearfix">
                <div class="font-normal h3 pull-left m-t-xs col-sm-6">
                    <i class="fa fa-code"></i>
                    <span> Form</span>
                </div>

                <div class="col-sm-6 pull-right">
                    <button type="button" class="btn btn-success btn-addon pull-right" ng-click="save()" ng-disabled="isSaving">
                        <i class="fa fa-check"></i> Salvar
                    </button>

                    <button type="button" class="btn btn-default btn-addon pull-right m-r-xs" ui-sref="app.$view-list">
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
                                    <tabset justified="true" class="tab-container">
                                        <tab heading="Tab 1">
                                            <div ng-include="'src/$viewDir/'"></div>
                                        </tab>
                                    </tabset>
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
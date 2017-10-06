<div class="hbox hbox-auto-xs  " >
    <div class="col lter b-l">

        <div class="vbox">
            <!--Start:Toolbar -->
            <div class="wrapper-sm bg-light lter b-b clearfix">
                <div class="font-normal h3 col-sm-6 m-t-xs">
                    <i class="fa fa-list"></i> Lista
                </div>
                <div class="col-sm-6 pull-right">
                    <button type="button" class="btn btn-danger btn-addon pull-right" ui-sref="app.$VIEW-create" acl="f-$VIEW-create">
                        <i class="fa fa-plus"></i> Novo
                    </button>
                    <button type="button" class="btn btn-addon pull-right m-r-sm" ng-class="DataStore.isActiveClass()" ng-click="Filter.open()">
                        <i class="fa fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            <div class="row-row">
                <div class="cell">
                    <div class="cell-inner">
                        <!--Start:Content-->
                        <div class="wrapper-md">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <md-table-container>
                                            <table md-table md-row-select="DataStore.enableRowSelection" ng-model="DataStore.selected">
                                                <thead md-head md-order="DataStore.sort" md-on-reorder="reloadData">
                                                <tr md-row>
                                                    <th md-column md-order-by="column"><span>Column</span></th>
                                                    <th md-column><span></span></th>
                                                </tr>
                                                </thead>
                                                <tbody md-body>
                                                <tr md-row md-select="record" md-select-id="id" ng-repeat="record in DataStore.results">
                                                    <td md-cell>
                                                        column
                                                    </td>
                                                    <td md-cell class="action">
                                                        <md-icon ui-sref="app.$VIEW-show({id: record.id})">visibility</md-icon>
                                                        <md-icon ui-sref="app.$VIEW-edit({id: record.id})">edit</md-icon>
                                                        <md-icon ng-click="remove(record.id)">delete</md-icon>

                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tbody md-body ng-if="DataStore.results.length == 0">
                                                <tr md-row>
                                                    <td colspan="6" md-cell style="text-align: center;">
                                                        <h2><i class="fa fa-frown-o"></i> Desculpe, nenhum registro foi encontrado.</h2>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </md-table-container>

                                        <md-table-pagination md-limit="DataStore.paging.pageSize" md-limit-options="[10, 30, 50, 100]" md-page="DataStore.paging.currentPage" md-total="{{DataStore.total}}" md-on-paginate="reloadData" md-page-select></md-table-pagination>
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

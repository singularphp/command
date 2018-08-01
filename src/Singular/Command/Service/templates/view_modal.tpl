<div>
    <div class="modal-header">
        <h3 class="modal-title">
            <span><i class="fa fa-file"></i> Modal</span>
        </h3>
    </div>
    <div class="modal-body">
        <div class="row m-b-n m-t-xs">
            <form name="forms.modal" novalidate autocomplete="off">
                <div class="form-group col-sm-12">
                    <label class="control-label" for="perfil">Field </label>
                    <input class="form-control" type="text" autofocus placeholder="Field" id="field" name="field" ng-model="field" ng-maxlength="255" required>
                    <ng-messages for="forms.modal.field.$error" role="alert" ng-if="isSubmited || forms.modal.field.$touched">
                        <ng-message when="required" class="label label-danger">Field é obrigatório</ng-message>
                        <ng-message when="maxlength" class="label label-danger">O tamanho é 255</ng-message>
                    </ng-messages>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-sm-12 m-t-xs">
                <button class="btn btn-success btn-addon pull-right" ng-click="save()">
                    <i class="fa fa-check"></i>
                    <span>Salvar</span>
                </button>
                <button class="btn btn-default btn-addon pull-right m-r-sm" ng-click="cancel()"> <i class="fa fa-times"></i>
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>







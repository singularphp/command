<div ng-controller="$VIEW.FilterCtrl">
    <div class="row">
        <div class="form-group col-sm-12">
            <label class="control-label label-sm" for="field">Field </label>
            <div class="input-group">
                <input class="form-control" type="text" autofocus placeholder="Field" ng-model="filter.field" id="field" name="field">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-icon" type="button" ng-click="clear('field')" ng-disabled="!filter.field.length"><i class="fa fa-times"></i></button>
                </span>
            </div>
        </div>
    </div>
</div>
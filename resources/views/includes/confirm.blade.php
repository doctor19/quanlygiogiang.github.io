<div class="modal fade in modal-confirm" id="modal-default">
  <div class="modal-dialog" style="width: 28em;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">{{trans('labels.backend.common.delete')}}</h4>
        </div>
        <div class="modal-body">
          <p>{{trans('labels.backend.common.msg_confirm_delete')}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('labels.backend.common.close')}}</button>
          <a href="#" class="btn btn-primary btn-click-delete">{{trans('labels.backend.common.delete')}}</a>
        </div>
      </div>
    </div>
</div>
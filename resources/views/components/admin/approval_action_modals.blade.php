<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{!empty($action_model_text) ? $action_model_text : ''}} Confirm User Deletion</h4>
            </div>
            <div class="modal-body">
                <div class="text-center action-modal-message"></div>
                <ul class="action-modal-errors"></ul>
                <label>Reason to delete user:</label>
                <textarea style="width: 100%; height: 150px;" id="action_message"></textarea>
                <input type="hidden" id="action">
                <input type="hidden" id="action_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-url_sagment="{{!empty($action_model_url) ? $action_model_url : ''}}" onclick="getAction(this)">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

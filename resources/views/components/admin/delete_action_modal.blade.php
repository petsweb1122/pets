<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Are You Sure! You want to delete this.</h4>
            </div>
            <input type="hidden" id="delete_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default bg-green" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger"  onclick="getDeleteAction()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

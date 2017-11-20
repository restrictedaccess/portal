<div class="modal" id="add-skill-task-popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">Add Skill</h4>
            </div>
            <div class="modal-body">
                <form method="POST" class="edit-task">
                    <div class="input-group">
                        <input type="hidden" name="type" id="updateType"/>
                        <input type="hidden" class="sub_category_id" name="sub_category_id" id="updateSubCategoryId"/>
                        <input name="value" type="text" class="form-control input-sm" id="updateName" placeholder="Enter Skill/Task Name Here">
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-add-skill-task">
                                Add
                            </button> </span>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_rs_chat_pop">
                    Close
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
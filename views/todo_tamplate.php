    <div id="project_<?= $result['id'] ?>" class="project">
        <script type="text/javascript">
        $(document).ready(function() {
            $('#table-<?= $result['id'] ?>').tableDnD({
                onDrop: function(table, row) {
                    $change = decodeURIComponent($.tableDnD.serialize());
                                
                    $.ajax({
                        url: '/index.php',
                        type: 'post',
                        data:  {ajax: true, page: 'task', change: true, code: change},
                        success: function(data) {  
                            //$('#table-'+ project_id + ' tbody').prepend(data);
                        }
                    });
                },
                dragHandle: ".dragHandle"
            });

            $("#table-<?= $result['id'] ?>").find("tr").hover(function() {
                $(this.cells[2]).addClass('showDragHandle');
            }, function() {
                $(this.cells[2]).removeClass('showDragHandle');
            });

        });
        </script>
        <div class="project_box" >
            <form name="table-<?= $result['id'] ?>" class="form-<?= $result['id'] ?>">
                <table class="table-bordered" id="table-<?= $result['id'] ?>">
                    <div class="tr_head">
                        <div><img src="/images/notepad.png"></div>
                        <div class="project_name"><?= $result['name'] ?></div>
                        <div>
                            <a href="javascript:void(0);" class="edit_project" id="<?= $result['id'] ?>"><img style="height: 20px;" src="/images/edit_project.png"></a>
                                | 
                            <a href="javascript:void(0);" class="delete_project" id="<?= $result['id'] ?>"><img style="height: 28px;" src="/images/delete_project.png"></a>
                         </div>
                    </div>
                    <div class="clear"></div>
                    <div class="tr_search">
                        <div class="multiple_delete" id="<?= $result['id'] ?>"><a href="javascript:void(0);"><img src="/images/all_delete.png"></a></div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Start typing here to create a task">
                            <button type="button" id="<?= $result['id'] ?>" class="btn btn-default add_task">Add Task</button>
                        </div> 
                    </div>
                    <div class="clear"></div>
                    <tbody></tbody>
                </table>
            </form>
        </div>
    </div>
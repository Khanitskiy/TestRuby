<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TODO LIST</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="/style/default.css" />
        <link rel="stylesheet" href="/style/bootstrap.css">
        <link rel="stylesheet" href="/style/bootstrap-theme.css">
        <script src="/script/jquery-1.11.2.min.js"></script>
        <script src="/script/jquery-migrate-1.2.1.min.js"></script>
        <script src="/script/jquery.tablednd.js"></script>
        <script src="/script/bootstrap.js"></script> 
        <script src="/script/default.js"></script>
    </head>
    <body>
        <div class="content">
            <div id="all_projects">
                <?php foreach($result as $key => $value) { ?>
                <div id="project_<?= $value['id'] ?>" class="project">
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $('#table-<?= $value['id'] ?>').tableDnD({
                            onDrop: function(table, row) {
                                change = $.tableDnD.serialize();
                                
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

                        $("#table-<?= $value['id'] ?>").find("tr").hover(function() {
                            $(this.cells[2]).addClass('showDragHandle');
                        }, function() {
                            $(this.cells[2]).removeClass('showDragHandle');
                        });

                    });
                    </script>
                    <div class="project_box" >
                        <form name="table-<?= $value['id'] ?>" class="form-<?= $value['id'] ?>">
                            <table class="table-bordered" id="table-<?= $value['id'] ?>">
                                <div class="tr_head">
                                    <div><img src="/images/notepad.png"></div>
                                    <div class="project_name"><?= $value['name'] ?></div>
                                    <div>
                                        <a href="javascript:void(0);" class="edit_project" id="<?= $value['id'] ?>"><img style="height: 20px;" src="/images/edit_project.png"></a>
                                            | 
                                        <a href="javascript:void(0);" class="delete_project" id="<?= $value['id'] ?>"><img style="height: 28px;" src="/images/delete_project.png"></a>
                                     </div>
                                </div>
                                <div class="clear"></div>
                                <div class="tr_search">
                                    <div class="multiple_delete" id="<?= $value['id'] ?>"><a href="javascript:void(0);"><img src="/images/all_delete.png"></a></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control name_add_task" placeholder="Start typing here to create a task">
                                        <button type="button" id="<?= $value['id'] ?>" class="btn btn-default add_task">Add Task</button>
                                    </div> 
                                </div>
                                <div class="clear"></div>
                                <tbody>
                                <?php foreach($value['tasks'] as $key=>$val) { ?>
                                    <tr id="tr_<?= $val['id'] ?>" class="<?= $val['status'] ? 'task_active' : 'task_close' ?>">
                                        <td><input type="checkbox" name="<?= $val['id'] ?>"></td>
                                        <td class="task_name"><?= $val['name'] ?></td>
                                        <td class="dragHandle">&nbsp</td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit_task" id="<?= $val['id'] ?>">
                                                <img class="edit_task_img" src="/images/edit_task.png">
                                            </a>
                                                |
                                            <a href="javascript:void(0);" class="delete_task" id="<?= $val['id'] ?>">
                                                <img class="delete_task_img" src="/images/delete_task.png">
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <div class="add_todo">
                <input type="submit" id="add_todo_form" class="btn btn-primary" value="Add TODO list">
            </div>
            
            <div id="add_project">
                <h4 class="h4_popup">Add project</h4> <div class="exit-add-project"><img src="/images/close_popup.png"></div>
                <input type="text" name="text" placeholder="Project name" class="form-control" id="project_name_add">
                <input type="button" class="btn btn-default" name="add_project" value="Add" id="add_todo">
            </div>
            <div id="edit_project">
                <h4 class="h4_popup">Edit project</h4> <div class="exit-edit-project"><img src="/images/close_popup.png"></div>
                <input type="text" name="text" class="form-control" data-id="" id="project_name_edit">
                <input type="button" class="btn btn-default" name="edit_project" value="Save" id="edit_project_button">
            </div>
            <div id="edit_task">
                <h4 class="h4_popup">Edit task</h4> <div class="exit-edit-task"><img src="/images/close_popup.png"></div>
                <div class="clear"></div>
                <input type="text" name="text" class="form-control" data-id="" id="task_name_edit">
                <select class="form-control edit_task_select" name="status">
                    <option value="0">Close</option>
                    <option value="1">Active</option>
                </select>
                <input type="button" class="btn btn-default" name="edit_task" value="Save" id="edit_task_button">
            </div>
            <div id="fade"></div>
            <div style="position: fixed; top:10px; left: 20px;"><a style="font-size: 20px; font-weight: bold" href="/index.php?page=logout">EXIT</a></div>
        </div>
    </body>
</html>
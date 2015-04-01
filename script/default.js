$(document).ready(function() { 
    
    $('body').delegate('.edit_project', 'click', function(){
        name = $('#project_'+ $(this).attr('id') + ' .project_name').text();
        $('#project_name_edit').val(name);
        $('#project_name_edit').attr({'data-id': $(this).attr('id')});

        
        $('#edit_project').show();
        $('#fade').show();
    });
    
    $('body').delegate('.edit_task', 'click', function(){
        name = $('#tr_'+ $(this).attr('id') + ' .task_name').text();
        status = $('#tr_'+ $(this).attr('id')).attr('class');
        $('#task_name_edit').attr({'data-id': $(this).attr('id')});
        
        $('#task_name_edit').val(name);
        if(status == 'task_close') {
            $(".edit_task_select [value='0']").attr("selected", "selected");
        } 
        if(status == 'task_active') {
            $(".edit_task_select [value='1']").attr("selected", "selected");
        }

        $('#edit_task').show();
        $('#fade').show();
    });
    
    $('body').delegate('#add_todo_form', 'click', function(){
        $('#add_project').show();
        $('#fade').show();
    });
    
    $('body').delegate('#fade', 'click', function(){
        $('#add_project').hide();
        $('#edit_project').hide();
        $('#edit_task').hide();
        $('#fade').hide();
    });
    
    $('body').delegate('.exit-add-project', 'click', function(){
        $('#add_project').hide();
        $('#fade').hide();
    });
    
    $('body').delegate('.exit-edit-project', 'click', function(){
        $('#edit_project').hide();
        $('#fade').hide();
    });
    
    $('body').delegate('.exit-edit-task', 'click', function(){
        $('#edit_task').hide();
        $('#fade').hide();
    });
    
    // Ajax добавление проекта
    $('body').delegate('#add_todo', 'click', function(){
        project_name = escape($('#project_name_add').val());
        $.ajax({
            url: '/index.php',
            type: 'post',
            data:  {name: project_name, ajax: true, page: 'project', add: true},
            success: function(data) {
                $('#all_projects').append(data);
                $('#add_project').hide();
                $('#fade').hide();
                $('#project_name_add').val('');
            }
        });
    });
    
    
    // Ajax удаление проекта
    $('body').delegate('.delete_project', 'click', function(){
        result = confirm("Are you sure you want to delete this project?");
        if(result) {
            delete_id = $(this).attr('id');
            $.ajax({
                url: '/index.php',
                type: 'post',
                data:  {delete_id: delete_id, ajax: true, page: 'project', delete: true},
                success: function(data) {
                    $('#project_'+ delete_id).remove();
                }
            }); 
        }
    });
    
    
    // Ajax отправка редактированного имени проекта
    $('body').delegate('#edit_project_button', 'click', function(){
        project_name = escape($('#project_name_edit').val());
        id = $('#project_name_edit').attr('data-id');
        $.ajax({
            url: '/index.php',
            type: 'post',
            data:  {project_id: id, name: project_name, ajax: true, page: 'project', edit: true},
            success: function(data) {
                $('#project_'+ id + ' .project_name').text($('#project_name_edit').val());
                $('#edit_project').hide();
                $('#fade').hide();
            }
        });
    });
    
    // Ajax отправка редактированного имени и статуса задачи
    $('body').delegate('#edit_task_button', 'click', function(){
        task_name = escape($('#task_name_edit').val());
        status = $('.edit_task_select :selected').val();
        id = $('#task_name_edit').attr('data-id');
        $.ajax({
            url: '/index.php',
            type: 'post',
            data:  {task_id: id, name: task_name, status: status, ajax: true, page: 'task', edit: true},
            success: function(data) {
                $('#tr_'+ id + ' .task_name').text($('#task_name_edit').val());
                $('#tr_'+ id).removeClass();
                if(status == 1) {
                    $('#tr_'+ id).addClass('task_active');
                } else {
                    $('#tr_'+ id).addClass('task_close');
                }
                $('#edit_task').hide();
                $('#fade').hide();
            }
        });
    });
    
    // Ajax добавление новой задачи
    $('body').delegate('.add_task', 'click', function(){
        name_add_task = escape($(this).siblings().val());
        project_id = $(this).attr('id');
        //alert(project_id);
        $.ajax({
            url: '/index.php',
            type: 'post',
            data:  {project_id: project_id, name: name_add_task, ajax: true, page: 'task', add: true},
            success: function(data) {  
                $('#table-'+ project_id + ' tbody').prepend(data);  
                tableDnD_ajax(project_id);

            }
        });
    });
    
    function tableDnD_ajax(project_id) {
    $('#table-'+project_id).tableDnD({
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

    $("#table-"+project_id).find("tr").hover(function() {
        $(this.cells[2]).addClass('showDragHandle');
    }, function() {
        $(this.cells[2]).removeClass('showDragHandle');
    });
    };

    
    // Ajax удаление задачи
    $('body').delegate('.delete_task', 'click', function(){
        result = confirm("Are you sure you want to delete this task?");
        if(result) {
            task_id = $(this).attr('id');
            $.ajax({
                url: '/index.php',
                type: 'post',
                data:  {task_id: task_id, ajax: true, page: 'task', delete: true},
                success: function(data) {  
                    $('#tr_'+task_id).remove();
                }
            }); 
        } 
    });
    
    // Ajax множественное удаление задач
    $('body').delegate('.multiple_delete', 'click', function(){
        result = confirm("Are you sure you want to delete this tasks?");
        if(result) {
            project_id = $(this).attr('id');
            form_checkbox = $('.form-'+project_id).serialize();
            tasks = $('.form-'+project_id).serializeArray()

            $.ajax({
                url: '/index.php',
                type: 'post',
                data:  {project_id: project_id, form_checkbox: form_checkbox, ajax: true, page: 'task', multiple_delete: true},
                success: function(data) {  
                    jQuery.each( tasks, function( i, task ) {
                        $('#tr_'+task.name).remove();
                    });
                }
            });
        }
    });
    
     
});
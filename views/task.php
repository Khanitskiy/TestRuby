    <tr id="tr_<?= $task['id'] ?>">
        <td><input type="checkbox" name="<?= $task['id'] ?>" class="task_active"></td>
        <td class="task_name"><?= $task['name'] ?></td>
        <td class="dragHandle">&nbsp</td>
        <td>
            <a href="javascript:void(0);" class="edit_task" id="<?= $task['id'] ?>">
                <img class="edit_task_img" src="/images/edit_task.png">
            </a>
                |
            <a href="javascript:void(0);" class="delete_task" id="<?= $task['id'] ?>">
                <img class="delete_task_img" src="/images/delete_task.png">
            </a>
        </td>
    </tr>

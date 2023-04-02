<?php
    require '../config.php';

    $ajax = database::array_single("SELECT * FROM tasks WHERE ID = '$_POST[ID]'");

?>

<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
      <div class="modal-body">
          <input type="hidden" name="task_id" value="<?php echo $ajax['ID'];?>">
          <input type="text" name="task_name_edit" value="<?php echo $ajax['TASK'];?>">
          <input type="date" name="task_date_edit" value="<?php echo $ajax['DATE'];?>">
      <select name="task_type_edit" value="<?php echo $ajax['STATUS'];?>">
          <option>new</option>
          <option>completed</option>
          <option>process</option>
      </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="edit">Edit task</button>
      </div>
      </form>
    </div>
  </div>

<?php
    error_reporting();
 // echo '<pre>'; print_r($_POST); echo '</pre>';
if(isset($_POST['add_task'])){
  $m_query = database::query("INSERT INTO `tasks` (`USER_ID`, `TASK`, `DATE`, `STATUS`) 
  VALUES ('$_SESSION[user_id]', '$_POST[task_name]', '$_POST[task_date]', '$_POST[task_type]');");
  header("Location: index.php");
}

  
if(isset($_POST['edit'])){
  $update = database::query("UPDATE `tasks` SET `TASK`='$_POST[task_name_edit]', 
  `DATE`='$_POST[task_date_edit]', `STATUS`='$_POST[task_type_edit]' WHERE `tasks`.`ID`='$_POST[task_id]'");
 
  header("Location: index.php");
}

  if(isset($_GET['task_id'])){
    $delete_task = database::query("DELETE FROM tasks WHERE ID = '$_GET[task_id]';");
      header("Location: index.php");
  } 
?>

<script>

function edit_ajax(id) {

 var request = $.ajax({
  url: "ajax/edit_task.php",
  method: "POST",
  data: {ID : id}
 });

  request.done(function(data){
    $('#edit_task_ajax').html(data);
    $('#edit_task_ajax').modal('show');
    
  });
}

</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="taskstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <link
        href="dist/mdb.min.css"
        rel="stylesheet"
    />
</head>
    <body>
    <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
          <div class="card-body py-4 px-4 px-md-5">
              <form method="POST">
              <div>
                <button class="btn btn-danger btn-sm" name="back">Back</button>
              </div>
              </form>
              <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
              <i class="fas fa-check-square me-1"></i>
              <u>My Todo-s</u>
            </p>

            <div class="pb-2">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row align-items-center">
                    <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                      placeholder="Add new...">
                    <a href="#!" data-mdb-toggle="tooltip" title="Set due date"><i
                        class="fas fa-calendar-alt fa-lg me-3"></i></a>
                    <div>
                    <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#add_task">
                      Add
                    </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4">
            
            <form>
              <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
              <p class="small mb-0 me-2 text-muted">Filter</p>
                <select class="select" name="filter_status" onchange="this.form.submit()">
                  <option <?php if($_GET['filter_status']== 'all') {echo 'selected';}?>>all</option>
                  <option <?php if($_GET['filter_status']== 'completed') {echo 'selected';}?>>completed</option>
                  <option <?php if($_GET['filter_status']== 'new') {echo 'selected';}?>>new</option>
                  <option <?php if($_GET['filter_status']== 'process') {echo 'selected';}?>>process</option>
                </select>
              <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
                <select class="select">
                  <option value="1">Added date</option>
                  <option value="2">Due date</option>
                </select>
                <a href="#!" style="color: #23af89;" data-mdb-toggle="tooltip" title="Ascending"><i
                    class="fas fa-sort-amount-down-alt ms-2"></i></a>
            </div>
            </form>
            
  <?php
        if(isset($_GET['filter_status'])){
          if($_GET['filter_status'] == 'new'){  
            $status = "AND STATUS = 'new'";
          }
          if($_GET['filter_status'] == 'completed'){  
            $status = "AND STATUS = 'completed'";
          }
          if($_GET['filter_status'] == 'process'){  
            $status = "AND STATUS = 'process'";
          }
  
      }
      
      //echo '<pre>'; print_r($task_list); echo '</pre>';
  ?>        
            <?php $task_list = database::array_all("SELECT * FROM tasks WHERE USER_ID = '$_SESSION[user_id]' $status");
                foreach($task_list as $key):?>
          
            <ul class="list-group list-group-horizontal rounded-0 bg-transparent">
              <li
                class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                <p class="lead fw-normal mb-0"><?php echo $key['TASK'];?></p>
              </li>
              <li class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent" style="margin-right: 80px; float: right;">
                <p class="small mb-0"><i class="fas fa-info-circle me-2"></i><?php echo $key['STATUS'];?></p>
                </li>
              <div style="margin-right: 36%; float: right;">
                <p class="small mb-0"><i class="fas fa-calendar-check me-2"></i><?php echo $key['DATE'];?></p>
              </div>
              <li class="list-inline-item">
                  <button class="btn btn-success btn-sm rounded-0" onclick="edit_ajax(<?php echo $key['ID'];?>)" 
                  type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
              </li>
              <li class="list-inline-item">
                  <button class="btn btn-primary btn-sm rounded-0" value="<?=htmlspecialchars(json_encode($key))?>"
                  onclick="edit_task(JSON.stringify(value))" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
              </li>
              <li class="list-inline-item">
                  <button class="btn btn-danger btn-sm rounded-0" onclick="delete_task(<?php echo $key['ID'];?>)"
                   type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                  <i class="fa fa-trash"></i></button>
              </li>
            </ul>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="edit_task_ajax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>

<!--Edit task-->
 <div class="modal fade" id="edit_task" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
      <div class="modal-body">
          <input type="hidden" name="task_id">
          <input type="text" name="task_name_edit">
          <input type="date" name="task_date_edit">
          <select class="select" name="task_type_edit">
                <option>completed</option>
                <option>new</option>
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
</div>

<div class="container d-flex justify-content-center">
    <div id="delete_task" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">   
                <div class="modal-body p-0">
                    <div class="card border-0 p-sm-3 p-2 justify-content-center">
                        <div class="card-header pb-0 bg-white border-0 ">
                          <div class="row">
                            <div class="col ml-auto">
                              <button type="button" class="close" data-mdb-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span> </button>
                              </div> 
                              <form method="GET">
                              </div>
                                <p class="font-weight-bold mb-2">Are you sure you wanna delete this ?</p>
                              </div>
                              <div class="card-body px-sm-4 mb-2 pt-1 pb-0"> 
                              <div class="row justify-content-end no-gutters">
                              <div class="modal-body">
                                <input type="hidden" name="task_id">
                              </div>
                              <div class="col-auto">
                                <button type="button" class="btn btn-light text-muted" data-mdb-dismiss="modal">Cancel</button>
                              </div>
                              <div class="col-auto">
                                <button type="submit" class="btn btn-danger px-4" data-mdb-dismiss="modal">Delete</button>
                              </div>
                            </div>
                        </div>
                      </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add task-->
  <div class="modal fade" id="add_task" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
      <div class="modal-body">
          <input type="text" name="task_name">
          <input type="date" name="task_date">
          <select class="select" name="task_type">
                <option>new</option>
                <option>completed</option>
                <option>process</option>
          </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add_task">Add task</button>
      </div>
      </form>
    </div>
  </div>
</div>
</section>
</body>
<script
  type="text/javascript"
  src="dist/mdb.min.js"
></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function (){

edit_task = function (value) {
    var jsonValue = JSON.parse(JSON.parse(value));
    
    $('[name=task_id]').val(jsonValue.ID);
    $('[name=task_name_edit]').val(jsonValue.TASK);
    $('[name=task_date_edit]').val(jsonValue.DATE);
    $('[name=task_type_edit]').val(jsonValue.STATUS);
    
    $('#edit_task').modal("show");
}


delete_task = function (id) {
     
    $('[name=task_id]').val(id);
    
    $('#delete_task').modal("show");
}
});
</script>
</html>
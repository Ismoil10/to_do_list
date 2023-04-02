
<?php
	error_reporting();
if(isset($_POST['login_button'])){
	$select = database::array_single("SELECT * FROM users WHERE LOGIN = '$_POST[login]' 
  AND PASSWORD = '$_POST[password]'");
	if(isset($select['ID'])){
		$_SESSION['login'] = 1;
		$_SESSION['user_id'] = $select['ID'];
		header("Location: index.php");
	}
}

if(isset($_POST['sign_button'])){
                                                                              
	$select = database::array_single("SELECT * FROM users WHERE LOGIN = '$_POST[login]'");
  //echo '<pre>'; print_r($select); echo '</pre>';
  
	if(isset($select['ID'])){
		  echo "<script> alert('That username is taken, Try another!'); </script>";
	}else{
		  $add_user = database::query("INSERT INTO users (NAME, LOGIN, PASSWORD) 
	VALUES ('$_POST[name]','$_POST[login]','$_POST[password]')");
	header("Location: index.php");
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
	<link rel="stylesheet" href="dist/loginstyle.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
</head>
    <body>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="card">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center">
                  <a class="nav-link active btl" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a>
                </li>
                <li class="nav-item text-center">
                  <a class="nav-link btr" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Signup</a>
                </li>
               
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  <form method="POST">
                  <div class="form px-4 pt-5">

                    <input type="text" name="login" class="form-control">

                    <input type="password" name="password" class="form-control">
                    <button class="btn btn-primary btn-block" name="login_button">Login</button>

                  </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                  
                <form method="POST">
                  <div class="form px-4">

                    <input type="text" name="name" class="form-control" placeholder="Name">

                    <input type="text" name="login" class="form-control" placeholder="Login">

                    <input type="text" name="password" class="form-control" placeholder="Password">

                    <button class="btn btn-primary btn-block" name="sign_button">Signup</button>
                  </div>
                  </form>
                </div>    
        	</div>
		</div>
      </div>   
    </body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>

<?php
    error_reporting(0);
    session_start();
    require 'config.php';
    //echo '<pre>'; print_r($_POST); echo'</pre>';
if(isset($_SESSION['login'])){
        require 'task.php';
}
if(!isset($_SESSION['login'])){
        require 'login.php';
}
if(isset($_POST['back'])){
        session_destroy(); 
    header("Location: index.php");
}
?> 

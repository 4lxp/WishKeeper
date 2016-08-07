<?php

  include 'Database.php';

  $username_login = mysqli_real_escape_string($conn, $_POST['username_login']);
  $password_login = mysqli_real_escape_string($conn, $_POST['password_login']);
  $password_login = md5($password_login);

  $sel_user = "select * from Users where Username='$username_login' AND Password='$password_login'";

  $run_user = mysqli_query($conn, $sel_user);

  $check_user = mysqli_num_rows($run_user);

  if($check_user>0){

    session_start();

    $_SESSION['username_login']=$username_login;

    $result=true;

  }

  else {

    $result="Errore nel login";

  }

  $conn->close();

  echo $result;


?>

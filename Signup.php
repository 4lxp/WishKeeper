<?php

  include 'Database.php';

  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $username_signup = mysqli_real_escape_string($conn, $_POST['username_signup']);
  $password_signup = mysqli_real_escape_string($conn, $_POST['password_signup']);
  $password_signup = md5($password_signup);

  $sql = "INSERT INTO Users (Name, Surname, Username, Password)
  VALUES ('$first_name','$last_name', '$username_signup','$password_signup')";

  if ($conn->query($sql) === true) {
    $result="Registrazione avvenuta con successo";
  }

  else {
    $result=$conn->error;
  }

  $conn->close();

  echo $result;

?>

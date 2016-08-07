<?php

session_start();

include 'Database.php';

$user_id = $_SESSION['user_id'];

//Elimino prima tutti i prodotti dell'utente
$sql = "DELETE FROM Products WHERE User_ID=$user_id";

if ($conn->query($sql) === TRUE) {
  $res= true;
}

else {
  $res= "Error: " . $sql . "<br>" . $conn->error;
}

//Elimino l'account dell'utente
$sql = "DELETE FROM Users WHERE User_ID=$user_id";

if ($conn->query($sql) === TRUE) {
  $res= true;
}

else {
  $res= "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

session_destroy();

echo $res;

?>

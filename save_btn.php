<?php

  $Username = $_POST['Username'];
  $AlcholVal = $_POST['alcValue'];

  //Database Connection
  $servername = "localhost";
  $username = "Arduino";
  $password = "Tee@IDC30BI";
  $dbname = "logins";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
  }
  else {
    $stmt = $conn->prepare("INSERT INTO details(Username,AlcoholVal) values(?,?)");
    $stmt->bind_param("ss", $Username,$AlcholVal);
    $stmt->execute();
    echo "Registration successfully...";
    $stmt->close();
    $conn->close();
  }

 ?>

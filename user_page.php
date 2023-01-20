<?php

@include 'config.php';
@include 'configs.php';
@include 'ardValues.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['email'])){

}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

     <title>user page</title>

     <!-- custom css file link  -->
     <link rel="stylesheet" href="styling.css">

  </head>
<body>

  <nav class="navbar bg-light">
    <div class="container-fluid">
      <a class="navbar-brand">Alcohol Displaying Alarm System</a>
      <button type="button" class="btn-close" aria-label="Close"><a href="logout.php" class="btn"></a></button>
    </div>
  </nav>
  <div class="container">


     <div class="content">

        <h3>hi, <span>user</span></h3>
        <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
        <p>this is an user page</p>


        <p>
          <?php
              if (isset($_POST['display'])) {
                $displayN = $_SESSION['user_name'];
              //  $displayE = $_SESSION['email'];

                   echo $displayN;
                   echo "'s results are: ";

                  $lastR = "SELECT * FROM tbl_temp ORDER BY temp_id DESC LIMIT 1";
                  $lastR_run = mysqli_query($conn1,$lastR);

                  while ($row = mysqli_fetch_array($lastR_run)) {

                    echo $row['temp_value'];
                  }
                }





        ?></p>
        <?php
                $lastR = "SELECT * FROM tbl_temp ORDER BY temp_id DESC LIMIT 1";
                $lastR_run = mysqli_query($conn1,$lastR);

                while ($row = mysqli_fetch_array($lastR_run)) {
                  $alcValue = $row['temp_value'];
                  //echo $alcValue;
                }


          $Username = $_SESSION['user_name'];
          if($row) {
            $AlcholVal = $row['temp_value'];
          }


          //Database Connection
          $servername = "localhost";
          $username = "Arduino";
          $password = "Tee@IDC30BI";
          $dbname = "logins";

          $conn = new mysqli($servername, $username, $password, $dbname);
          if (isset($_POST['display'])) {
            if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }
            else {
              $stmt = $conn->prepare("INSERT INTO details(Username,AlcoholVal) values(?,?)");
              $stmt->bind_param("ss", $displayN,$alcValue);
              $stmt->execute();
              //echo "Data Saved";
              $stmt->close();
              $conn->close();
            }
          }

         ?>

        <div class="">
          <form  method="post">
            <input class="btn" type="submit" name="display" value="Show Results">
            <input  class="btn" type="submit" name="imageButton" value="Show Records">
          </form>
        </div>





     </div>
  </div>
  <div class="displayPhoto">
    <form method="post">
      <?php
            $lastR = "SELECT * FROM tbl_temp ORDER BY temp_id DESC LIMIT 1";
            $lastR_run = mysqli_query($conn1,$lastR);
            if (isset($_POST['display'])) {
              while ($row = mysqli_fetch_array($lastR_run)) {
                //style="height: 70px; width: 70px; background-color: black; text-align: center;
                $alcValue = $row['temp_value'];
                //echo $alcValue;
                if ($alcValue>2000) : ?>
                    <img src="high.jfif" alt="" >
                  <?php else : ?>
                      <img src="low.jfif" alt="">
                    <?php endif;
            }
          }
       ?>

    </form>
  </div>
  <form method="post">
    <div>
        <?php

          $uname = $_SESSION['user_name'];
            $connMax = new mysqli('localhost', 'Arduino', 'Tee@IDC30BI', 'logins');
              $sqlMax = "SELECT * FROM details WHERE Username='$uname'";
              $resultsMax = mysqli_query($connMax,$sqlMax);
              if (isset($_POST['imageButton'])) {
                ?>

                <h2 style="text-align: center;">Previous Data</h2><br><br>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Alcohol Values</th>
                      <th>Date and Time</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php
                while ($row = mysqli_fetch_array($resultsMax)) {

          ?>
              <tr>
                <td><?php echo $row['Username']; ?></td>
                <td><?php echo $row['AlcoholVal']; ?></td>
                <td><?php echo $row['Date & Time']; ?></td>
              </tr>
            <?php }}?>
      </tbody>
    </table>

  </div>

</form>

</body>
</html>

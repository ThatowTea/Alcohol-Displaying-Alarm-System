<?php

  @include 'config.php';
  @include 'configs.php';
  @include 'final_db';

  session_start();

  if(!isset($_SESSION['admin_name'])){
     header('location:login_form.php');
  }



?>

<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

     <title>admin page</title>

     <!-- custom css file link  -->
     <link rel="stylesheet" href="styling.css">
     <link rel="stylesheet" href="main.css">



  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar bg-light">
      <div class="container-fluid">
        <a class="navbar-brand">Alcohol Displaying Alarm System</a>
        <button type="button" class="btn-close" aria-label="Close"><a href="logout.php" class="btn"></a></button>
      </div>
    </nav>



    <div class="container">

       <div class="content">
          <h3>hi, <span>admin</span></h3>
          <h1>welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
          <p>this is an admin page</p>

          <form method="post">
            <input class="btn" type="submit" name="submitbtn" value="Show Data" >
            <input class="btn" type="submit" name=" highbtn" value="Highest Data" >
            <input class="btn" type="submit" name="lowbtn" value="Lowest Data" >
            <input class="btn" type="submit" name="registered" value="registered" >
          </form>
     </div>
   </div>



    <form method="post">
      <div>

            <?php
                $connD = new mysqli('localhost', 'Arduino', 'Tee@IDC30BI', 'logins');
                  $sql = "SELECT * FROM details";
                  $results = mysqli_query($connD,$sql);
                  if (isset($_POST['submitbtn'])) {
                    ?>

                    <h2 style="text-align: center;">All Data Stored</h2><br><br>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Alcohol Values</th>
                          <th>Date and Time</th>
                        </tr>
                      </thead>

                    <?php
                    while ($row = mysqli_fetch_array($results)) {

              ?>


                <tbody>
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

      <form method="post">
        <div class="fheader">

            <?php
                $connMax = new mysqli('localhost', 'Arduino', 'Tee@IDC30BI', 'logins');
                  $sqlMax = "SELECT * FROM details WHERE AlcoholVal=(SELECT min(AlcoholVal) FROM details)";
                  $resultsMax = mysqli_query($connMax,$sqlMax);
                  if (isset($_POST['lowbtn'])) {
                    ?>
                    <h2 style="text-align: center;">Lowest Data</h2><br><br>
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

      <form method="post">
        <div>

            <?php
                  $connMin = new mysqli('localhost', 'Arduino', 'Tee@IDC30BI', 'logins');
                  $sqlMin =  "SELECT * FROM details WHERE AlcoholVal=(SELECT Max(AlcoholVal) FROM details)";
                  $resultsMin = mysqli_query($connMin,$sqlMin);
                  if (isset($_POST['highbtn'])) {
                    ?>
                    <h2 style="text-align: center;">Highest Data</h2>
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
                    while ($row = mysqli_fetch_array($resultsMin)) {

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


        <form method="post">
          <div>

                <?php
                  //  $conn = new mysqli('localhost', 'Arduino', 'Tee@IDC30BI', 'user_db');
                      $sqlR = "SELECT * FROM user_form";
                      $resultsR = mysqli_query($conn,$sqlR);
                      if (isset($_POST['registered'])) {
                        ?>
                        <h2 style="text-align: center;">Registered Details</h2><br><br>
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Email Address</th>
                              <th>User Type</th>
                            </tr>
                          </thead>

                          <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($resultsR)) {

                  ?>
                      <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['user_type']; ?></td>
                      </tr>
                    <?php }}?>
              </tbody>
            </table>
          </div>

        </form>


  </body>
</html>

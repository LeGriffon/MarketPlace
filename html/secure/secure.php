<?php 
  session_start();/* Starts the session */
  session_save_path('/cgi-bin/tmp');
  if(!isset($_SESSION['UserData']['Username'])){
    header("location:../login.php");
    exit;
  }
  $servername = "ryanhaoyuanw39009.ipagemysql.com";
  $username = "ryanhw";
  $password = "ryanhw";

  $servername2 = "localhost";
  $username2 = "root";
  $password2 = "root";

  // Create connection
  $conn = new mysqli($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
      $conn = new mysqli($servername2, $username2, $password2);
  }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/secure.css">

    <title>User List</title>

</head>
<body>

    <?php include"../partials/secureHeader.html" ?>

    <div class='container-md container-fluid mt-5 pt-3'>
      <h1>Current User List <a href="manage.php"><span id="plusSign"><i class="fa fa-plus"></i></span></a></h1>
      <table class='table table-light table-sm table-bordered table-hover table-striped table-responsive-md' id="listUl">
        <thead class="thead-dark align-middle">
          <tr> 
            <th  class='align-middle' scope="col"> First Name </th> 
            <th  class='align-middle' scope="col"> Last Name </th> 
            <th  class='align-middle' scope="col"> Email </th> 
            <th  class='align-middle' scope="col"> Home Phone </th> 
            <th  class='align-middle' scope="col"> Cell Phone </th>
            <th  class='align-middle' scope="col"> Home Address </th> 
          </tr>
        </thead>

        <?php
            $query = "SELECT * FROM hyperkar.customers";
            // use exec() because no results are returned
            if($result = $conn->query($query)) {
              while($row = $result->fetch_assoc()) {
                $field1name = $row["first_name"];
                $field2name = $row["last_name"];
                $field3name = $row["email"];
                $field4name = $row["home_phone"];
                $field5name = $row["cell_phone"]; 
                $field6name = $row["home_address"]; 
                echo '<tr>
                            <td class="align-middle">' .$field1name. '</td>
                            <td class="align-middle">' .$field2name. '</td>
                            <td class="align-middle">' .$field3name. '</td>
                            <td class="align-middle" style="width:120px">' .$field4name. '</td>
                            <td class="align-middle" style="width:120px">' .$field5name. '</td>
                            <td class="align-middle">' .$field6name. '</td>
                      </tr>';
              }
            }
            else {
              echo "0 results";
            }
                  ?>
                  
      </table>
    </div>
    <?php include "../partials/secureFooter.html" ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
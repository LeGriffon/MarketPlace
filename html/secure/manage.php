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
    <link rel="stylesheet" type="text/css" href="assets/css/manage.css">

    <title>Manage User List</title>

</head>
<body>

    <?php include"../partials/secureHeader.html" ?>
    
    <div class="container mt-5 pt-3">
        <div class="jumbotron">
        <h1 class="display-4">New User MySql Database</h1>
        <p class="lead">Manage the MySql database via adding new users using below form. Please fill in all fields.</p>
        <hr class="my-4">
        <form action="manage.php" method="post" class="px-lg-5 mx-lg-5">
        <!-- Method can be set as POST for hiding values in URL-->
        <div class="form-group">
            <label for="firstName" >First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="lastName" >Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="email" >Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="homePhone" >Home Phone:</label>
            <input type="text" class="form-control" id="homePhone" name="homePhone" required>
        </div>
        <div class="form-group">
            <label for="cellPhone" >Cell Phone:</label>
            <input type="text" class="form-control" id="cellPhone" name="cellPhone" required>
        </div>
        <div class="form-group">
            <label for="homeAddress" >Home Address:</label>
            <textarea type="text" class="form-control" id="homeAddress" name="homeAddress" required></textarea>
        </div>

        <button class="btn btn-primary mb-2" name="submit" type="submit" value="Insert">ADD USER</button>

        <?php
            if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $homePhone = $_POST['homePhone'];
            $cellPhone = $_POST['cellPhone'];
            $homeAddress = $_POST['homeAddress'];
            if($firstName !='' && $lastName != '' && $email !='' && $homePhone != '' && $cellPhone != '' && $homeAddress != ''){
            //Insert Query of SQL
            $query = "INSERT INTO hyperkar.customers (`first_name`, `last_name`, `email`, `home_phone`, `cell_phone`, `home_address`) 
                        VALUES ('$firstName', '$lastName', '$email', '$homePhone', '$cellPhone', '$homeAddress')";
            if($conn->query($query)) {
                echo "<br><br><span>User Inserted successfully!!</span>";
            }
            else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
            }
            else{
            echo "<p>Insertion Failed <br/> Some Fields are Blank!</p>";
            }
            }
            ?>

      </form>
      </div>
    </div>

    <?php include"../partials/secureFooter.html" ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<?php 
  session_start(); /* Starts the session */
  session_save_path('/cgi-bin/tmp');


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
	
	/* Check Login form submitted */	
	if(isset($_POST['submit'])){		
		/* Check and assign submitted Username and Password to new variable */
		$username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $authenticateQuery = "SELECT * FROM hyperkar.users WHERE username = '$username' AND password = '$password'";
		$result = $conn->query($authenticateQuery);
		/* Check Username and Password existence in defined array */		
		if(mysqli_num_rows($result) > 0){
      $row = $result->fetch_assoc();
      $id = $row["id"];
      $historyQuery = "INSERT INTO hyperkar.visit_history (user_id) VALUES ('$id')";
      $conn->query($historyQuery);
			/* Success: Set session variables and redirect to Protected page  */
      $_SESSION['UserData']['Username']=$username;
      $_SESSION['UserData']['Id']=$id;
			header("location:products.php");
			exit;
    } 
    else {
			/*Unsuccessful attempt: Set error message */
			$msg="<span style='color:red'>Invalid Username or Password</span>";
		}
	}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link href="css/login.css" rel="stylesheet">

    <title>HyperKar</title>
  </head>
  
  <body>
    <?php include "html/partials/header.php" ?>

    <div class="wrapper fadeInDown pt-5 mt-5">

    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card card-signin flex-row my-5">
                    <div class="card-img-left d-none d-md-flex">
                        <!-- Background image for card set in CSS! -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center text-dark">Welcome Back</h5>
                        <form class="form-signin" method="post" name="Login_Form">
                            <div class="form-label-group">
                                <input type="email" id="inputUserame" name="username" class="form-control" placeholder="Username" required autofocus>
                                <label for="inputUserame">Username</label>
                            </div>
                            
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>

                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Login</button>
                            <a class="d-block text-center mt-2 small" href="signup.php">Please Sign Up If You Do Not Have An Account</a>
                            <br>
                            <?php 
                                if(isset($msg)){
                                echo $msg;
                                } 
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "html/partials/footer.html" ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="js/navaction.js"></script>

  </body>
</html>
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

    if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

        if($username !='' && $password1 != '' && $password2 !='' && ($password1 === $password2)){
            //Insert Query of SQL
            $query = "INSERT INTO hyperkar.users (`username`, `password`) 
                        VALUES ('$username', '$password1')";
            if($conn->query($query)) {
                $id = mysqli_insert_id($conn);
                $historyQuery = "INSERT INTO hyperkar.visit_history (user_id) VALUES ('$id')";
                $conn->query($historyQuery);

                // Preparing to post to other market place websites
                $url1 = 'http://pichao314.com/receive.php';
                $url2 = 'https://www.shengtao.website/company/api/users/upsert-user.php';
                $url3 = 'http://xunand.com/login.php';

                $myvars = array('username' => $username, 'password' => $password1);

                $ch1 = curl_init($url1);
                curl_setopt( $ch1, CURLOPT_POST, 1);
                curl_setopt( $ch1, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch1, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch1, CURLOPT_HEADER, 0);
                curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, 1);

                $ch2 = curl_init($url2);
                curl_setopt( $ch2, CURLOPT_POST, 1);
                curl_setopt( $ch2, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch2, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch2, CURLOPT_HEADER, 0);
                curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, 1);

                $ch3 = curl_init($url3);
                curl_setopt( $ch3, CURLOPT_POST, 1);
                curl_setopt( $ch3, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch3, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch3, CURLOPT_HEADER, 0);
                curl_setopt( $ch3, CURLOPT_RETURNTRANSFER, 1);

                //create the multiple cURL handle
                $mh = curl_multi_init();

                //add the handles
                curl_multi_add_handle($mh,$ch1);
                curl_multi_add_handle($mh,$ch2);
                curl_multi_add_handle($mh,$ch3);

                //execute the multi handle
                do {
                $status = curl_multi_exec($mh, $active);
                if ($active) {
                    curl_multi_select($mh);
                }
                } while ($active && $status == CURLM_OK);
            
                //close the handles
                curl_multi_remove_handle($mh, $ch1);
                curl_multi_remove_handle($mh, $ch2);
                curl_multi_remove_handle($mh, $ch3);
                curl_multi_close($mh);    

                $msg= "<p class='text-danger text-center'>User Created successfully! Go Ahead Logging in.</p>";
            }
            else {
                $msg= "<p class='text-danger text-center'>Error: Username Exists. Please Try Another One. </p>" . $conn->error;
            }
        }
        else{
            $msg= "<p class='text-danger text-center'>User Creation Failed. Passwords Not Match!</p>";
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
    <link href="css/signup.css" rel="stylesheet">

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
                        <h5 class="card-title text-center text-dark">Register</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <input type="email" id="inputUserame" name="username" class="form-control" placeholder="Username" required autofocus>
                                <label for="inputUserame">Username</label>
                            </div>
                            
                            <hr>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" name="password1" class="form-control" placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>
                            
                            <div class="form-label-group">
                                <input type="password" id="inputConfirmPassword" name="password2" class="form-control" placeholder="Password" required>
                                <label for="inputConfirmPassword">Confirm password</label>
                            </div>

                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Register</button>
                            <a class="d-block text-center mt-2 small" href="login.php">Sign In</a>

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
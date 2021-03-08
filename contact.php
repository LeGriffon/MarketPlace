<?php 
  session_start();/* Starts the session */
  session_save_path('/cgi-bin/tmp');
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
    <link rel="stylesheet" href="css/contact.css">

    <title>HyperKar</title>
  </head>
  
  <body>
    <?php include "./html/partials/header.php" ?>

    <div class="container-fluid">
      <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4">Get in Touch With Us</h3>
                  <div class="card w-70">
                    <div class="card-body">
                        <h5 class="card-title">Contact Us</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Please leave your contact inforamtion</h6>
                        <form>
                            <div class="form-group">
                                <label for="emailAddress">Email address</label>
                                <input type="email" class="form-control" id="emailAddress" placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label for="firstName">First name</label>
                                <textarea class="form-control" id="firstName" rows="1"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last name</label>
                                <textarea class="form-control" id="lastName" rows="1"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender">
                                    <option>Female</option>
                                    <option>Male</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="textInput">What's in your mind</label>
                                <textarea class="form-control" id="textInput" rows="3"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary mb-2">Send</button>
                            </div>
                        </form>
                    </div>
                </div>

            <div class="text-white text-center">
                <p class="lead login-heading mb-4">To find out more about us. Send us an message or drop a phone call.</p>
                <hr class="my-2">
                <p>
                    <?php
                    $myfile = fopen("html/contact/contactInfo.txt", "r") or die("Unable to open file!");
                        while(!feof($myfile)) {
                            echo fgets($myfile) . "<br>";
                        }
                        fclose($myfile);
                    ?>
                </p>
            </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    



    <?php include "./html/partials/footer.html" ?>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/navaction.js"></script>

  </body>
</html>
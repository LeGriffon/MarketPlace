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
    <link rel="stylesheet" href="css/index.css">

    <title>HyperKar</title>
  </head>
  
  <body>
    <?php include "./html/partials/header.php" ?>
  
    <div class="container marketing text-white pt-5 mt-5">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="rounded-circle mb-3" src="https://scontent-sjc3-1.xx.fbcdn.net/v/t1.0-9/13012618_10205764180054467_4046080245739604064_n.jpg?_nc_cat=109&_nc_sid=7aed08&_nc_ohc=lY_hASY4WS0AX_hBIKq&_nc_ht=scontent-sjc3-1.xx&oh=214c4df5f716f68a58cbc9a83fac4329&oe=5ED1D1F1" alt="founder picture" width="140" height="140">
        <h2>Founder: Ryan H. W</h2>
        <p>Foodie, travaller, coder.</p>
        <p>A dependable and detail-oriented software engineer based in Silicon Valley.</p>
        <p><a class="btn btn-secondary" href="https://www.linkedin.com/in/ryan-haoyuan-wang/" role="button">View Linkedin Page &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <!-- <div class="col-lg-4">
        <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
        <h2>Heading</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p> -->
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <!-- <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p> -->
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette text-white align-items-center px-5 mx-5">
      <div class="col-md-6">
        <h2 class="featurette-heading">Different background with suprises. <span class="text-muted">It'll blow your mind.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-6">
        <img class="featurette-image img-fluid mx-auto" src="imgs/aboutPage/photo-shanghai.jpeg" alt="Shanghai image">
      </div>
    </div>

    <hr class="featurette-divider">

    <?php include "./html/partials/footer.html" ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/navaction.js"></script>

  </body>
</html>
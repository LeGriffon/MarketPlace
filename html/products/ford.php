<?php
    session_start();/* Starts the session */
    session_save_path('/cgi-bin/tmp');
    
    $brand = "ford";
    $weblink = "https://www.familysavings.com/wp-content/uploads/2017/07/ford-1024x361.png";
    if(!isset($_COOKIE["history"])) {
      setcookie("history", $brand, time()+3600, "/","", 0);
  }
  
  else {
      $lastVisitsArr = explode(",", $_COOKIE['history']);
      if(($key = array_search($brand, $lastVisitsArr)) !== false) {
          unset($lastVisitsArr[$key]);
      }
      if(sizeof($lastVisitsArr) >= 5) {
          unset($lastVisitsArr[0]);
      }
      array_push($lastVisitsArr, $brand);
      $newHistory = implode(",", $lastVisitsArr);
      setcookie("history", $newHistory, time()+3600, "/","", 0);
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

  //View count update
  $query = "UPDATE hyperkar.pageview SET count=count+1 WHERE product=" . '"' . $brand . '"';
  $conn->query($query);

  // Product MySQL check
  $productExistQuery = "SELECT id, COUNT(*) AS count FROM hyperkar.products WHERE brand='$brand'";
  $productExistResult =  $conn->query($productExistQuery);
  $productExist = $productExistResult->fetch_assoc();
  if($productExist['count'] == 0){
    $addProductQuery = "INSERT INTO hyperkar.products (brand) VALUES ('$brand')";
    $conn->query($addProductQuery);
  }

  // User MySQL visit update
  if(isset($_SESSION['UserData']['Username'])){
    $userID = $_SESSION['UserData']['Id'];
    $productID = $productExist['id'];
    $userVisitQuery = "INSERT INTO hyperkar.visit_history (user_id, product_id) VALUES ('$userID', '$productID')";
    $userVisitResult =  $conn->query($userVisitQuery);
  }

  if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
    if(isset($_SESSION['UserData']['Username'])) {
      $id = $_SESSION['UserData']['Id'];
      $product = $brand;
      $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
      $review = isset($_POST['review']) ? $_POST['review'] : '';

      if($id !='' && $product != '' && $rating !='' && $review !=''){
          //Insert Query of SQL
          $query = "INSERT INTO hyperkar.reviews (id, product, rating, review) 
                      VALUES ('$id', '$product', '$rating', '$review')";
          if($conn->query($query)) {
              $msg= "<p class='text-danger text-center'>Reivew Submitted.</p>";
              $avg_update_query = "UPDATE hyperkar.products SET avg_rating=(SELECT CAST(avg(rating) AS DECIMAL(4,2)) FROM hyperkar.reviews GROUP BY '$product') WHERE brand='$product'";
              if($conn->query($avg_update_query)){
                $msg2 = "<p class='text-danger text-center'>Average updated!</p>";
              }
              else {
                $msg2 = "<p class='text-danger text-center'>" . $avg_update_query . "</p>" . $conn->error;
              }
          }
          else {
              $msg= "<p class='text-danger text-center'>Error: Review Failed. Please Try Another Time." . $query . "</p>" . $conn->error;
          }
      }
      else{
          $msg= "<p class='text-danger text-center'>Missing Fileds.</p>";
      }
    }
    else {
      $msg= "<p class='text-danger text-center'>You have to login first.</p>";
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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="productPages.css">

  <title>HyperKar</title>
</head>

<body>
<title>HyperKar</title>
</head>

<body>
  <?php include"../partials/productHeader.php" ?>

  <!-- Page Content -->
  <div class="container mt-5 pt-1">

  <!-- Heading Row -->
  <div class="row align-items-center my-5">
    <div class="col-lg-7">
      <img class="img-fluid rounded mb-4 mb-lg-0" src=<?php echo $weblink; ?> alt="">
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-5">
      <h1 class="font-weight-light text-white"><?php echo ucfirst($brand); ?></h1>
      <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, tenetur atque iure odio, aliquid corrupti facilis tempora, dolorem vel unde eaque debitis quae dolore laborum. Obcaecati, laborum? Recusandae, quasi quis.</p>
      <a class="btn btn-primary" href="#">Call to Action!</a>
    </div>
    <!-- /.col-md-4 -->
  </div>
  <!-- /.row -->

  <!-- Call to Action Well -->
  <div class="card bg-secondary my-5 py-4">
    <div class="card-body">
      <div class="container">
        <div class="row ml-1">
          <h4>Product's Rating</h4>
        </div>

        <div class="row mb-3 ml-1">
          <div class="containerdiv" title="Product's Rating">

            <?php
              $ratingQuery = "SELECT avg_rating FROM hyperkar.products WHERE brand='$brand'";
              $ratingQueryResult = $conn->query($ratingQuery);

              if ($ratingQueryResult->num_rows > 0) {
                // output data of each row
                $row = $ratingQueryResult->fetch_assoc();
                $avg_rating = $row['avg_rating'];
              }
              ?>

              <div>
                <img class="ratingstar" src="https://image.ibb.co/jpMUXa/stars_blank.png" alt="img">
              </div>
              <div class="cornerimage" style="width:<?php echo $avg_rating/5 * 100 . "%"; ?>">
                <img class="ratingstar" src="https://image.ibb.co/caxgdF/stars_full.png" alt="">
              </div>
          </div>
          <div class="ml-3"><h4><?php echo $avg_rating; ?> / 5.0</h4></div>
        </div>   
        
        <?php
          $reviewQuery = "SELECT username, rating, review, time FROM hyperkar.reviews INNER JOIN hyperkar.users ON reviews.id=users.id WHERE product='$brand' ORDER BY time DESC";
          if($reviewQueryResult = $conn->query($reviewQuery)){
            if ($reviewQueryResult->num_rows > 0) {
              // output data of each row
              while($row = $reviewQueryResult->fetch_assoc()){
                $user_rating = $row['rating'];
          ?>
                <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-2">
                              <p class="text-secondary text-center"><?php echo $row['time'] ?></p>
                          </div>
                          <div class="col-md-10">
                              <p>
                                  <a class="float-left" href="#"><strong><?php echo $row['username'] ?></strong></a>
                                  <div class="mb-3 mx-1">
                                    <div class="usercontainerdiv float-right" title="User's Rating">
                                        <div>
                                          <img class="userratingstar" src="https://image.ibb.co/jpMUXa/stars_blank.png" alt="img">
                                        </div>
                                        <div class="usercornerimage" style="width:<?php echo $user_rating/5 * 100 . "%"; ?>">
                                          <img class="userratingstar" src="https://image.ibb.co/caxgdF/stars_full.png" alt="">
                                        </div>
                                    </div>
                                  </div>   
                              </p>
                            <div class="clearfix"></div>
                              <p><?php echo $row['review'] ?></p>
                              <p>
                                  <a class="float-right btn btn-outline-dark ml-2"> <i class="fas fa-heart-broken"></i> Dislike</a>
                                  <a class="float-right btn text-white btn-danger"> <i class="fas fa-heart"></i> Like</a>
                            </p>
                          </div>
                      </div>
                  </div>
                </div>
          <?php    
              }
            }
          }
          else {
            echo '<div><h4>' . $reviewQueryResult . '</h4></div>';
          }
        ?>
      </div>
    </div>
  </div>

  <div class="card bg-secondary my-5 py-4">
    <div class="card-body">
      <div class="container">
        <form action="" method="post" >
          <div class="form-group px-3">
            <h4 for="rating">Overall Rating</h4>
          </div>
          <div class="form-group starrating risingstar d-flex justify-content-end flex-row-reverse px-3">
              <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star"></label>
              <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star"></label>
              <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star"></label>
              <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star"></label>
              <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
          </div>
          <div class="form-group px-3">
              <h4 for="textInput">Write your review</h4>
              <textarea class="form-control" id="textInput" name="review" rows="4"></textarea>
          </div>
          <div class="form-group text-center d-flex justify-content-start px-3">
              <button type="submit" name = "submit" class="btn btn-primary mb-2">Submit</button>
          </div>
          <?php
            if(isset($msg)){
              echo $msg;
            } if(isset($msg2)){
              echo $msg2;
            } 
          ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col-md-4 mb-5">
      <div class="card h-100">
        <div class="card-body">
          <h2 class="card-title">Card One</h2>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary btn-sm">More Info</a>
        </div>
      </div>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 mb-5">
      <div class="card h-100">
        <div class="card-body">
          <h2 class="card-title">Card Two</h2>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary btn-sm">More Info</a>
        </div>
      </div>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 mb-5">
      <div class="card h-100">
        <div class="card-body">
          <h2 class="card-title">Card Three</h2>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary btn-sm">More Info</a>
        </div>
      </div>
    </div>
    <!-- /.col-md-4 -->

  </div>
  <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <script>
    $(function () {
        $(document).scroll(function () {
            var $nav = $("#mainNavbar");
            $nav.toggleClass("scrolled", $(this).scrollTop() > $nav.height());
        });
    });
</script>

</body>
</html>
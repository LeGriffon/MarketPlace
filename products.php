<?php 
  session_start();/* Starts the session */
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
    <link rel="stylesheet" href="css/product.css">

    <title>HyperKar</title>
  </head>
  
  <body>
    
    <?php include "./html/partials/header.php" ?>

    <div class="pricing-header px-3 py-3 mt-5 pt-md-5 pb-md-4 mx-auto text-center text-white">
        <h1 class="display-4">Collaborating Partner's Pricing</h1>
        <p class="lead">We offer the best price that you can afford.<br>
          It is our best interest that you can have the best expierence with the best price.
        </p>
      </div>


      <?php
        if(isset($_COOKIE['history'])) { 
          $lastVisits = explode(",", $_COOKIE['history']);
      ?>


      <div class="container">
        <div class="card-deck mb-3 text-center">
          <div class="card text-white bg-dark mb-4 box-shadow text-center">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Most Rated 5 Products in HyperKar</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled mt-3 mb-4">
              <?php
                $query = "SELECT * FROM hyperkar.products ORDER BY avg_rating DESC LIMIT 5";
                // use exec() because no results are returned
                if($result = $conn->query($query)) {
                  $key = 1;
                  while($row = $result->fetch_assoc()) {
                    $brand = $row["brand"];
                    $avg_rating = $row["avg_rating"];
                    echo '<li><a href="html/products/' . $brand . '.php"><h5 class="card-title" style="color:white">' . "No." . $key++ . ": " . ucfirst($brand) . ": " . $avg_rating . " out of 5" . '</h5></a></li>';
                  }
                }
                else {
                  echo "No Rating Records";
                }
              ?>
              </ul>
            </div>
          </div>
          
          <div class="card text-white bg-dark mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Most Rated 5 Products in MarketPlace</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled mt-3 mb-4">
                <?php
                  $url0 = "http://ryanhw.com/api/top5rated.php";
                  $url1 = "http://pichao314.com/top5.php";
                  $url2 = "https://www.shengtao.website/company/api/products/rating-highest.php?limit=5";
                  $url3 = "http://xunand.com/top_rate.php";

                  // Initiate curl
                  $ch0 = curl_init();
                  $ch1 = curl_init();
                  $ch2 = curl_init();
                  $ch3 = curl_init();

                  // Will return the response, if false it print the response also set the url
                  curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch0, CURLOPT_URL,$url0);
                  
                  curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch1, CURLOPT_URL,$url1);
                  
                  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch2, CURLOPT_URL,$url2);
                  
                  curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch3, CURLOPT_URL,$url3);

                  //create the multiple cURL handle
                  $mh = curl_multi_init();

                  //add the handles
                  curl_multi_add_handle($mh,$ch0);
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
                  curl_multi_remove_handle($mh, $ch0);
                  curl_multi_remove_handle($mh, $ch1);
                  curl_multi_remove_handle($mh, $ch2);
                  curl_multi_remove_handle($mh, $ch3);
                  curl_multi_close($mh);

                  $result0 = curl_multi_getcontent($ch0);
                  $result1 = curl_multi_getcontent($ch1);
                  $result2 = curl_multi_getcontent($ch2);
                  $result3 = curl_multi_getcontent($ch3);

                  // all of our requests are done, now access the results
                  $result0 = json_decode($result0, true);
                  $result1 = json_decode($result1, true);
                  $result2 = json_decode($result2, true);
                  $result3 = json_decode($result3, true);

                  $finalResult = array_merge($result0, $result1);
                  $finalResult = array_merge($finalResult, $result2);
                  $finalResult = array_merge($finalResult, $result3);

                  usort($finalResult, function ($value1, $value2) {
                    return strcmp($value2['average_rating'], $value1['average_rating']);
                  });

                  $ranking = 1;
                  for($i = 0 ; $i < 5; $i+=1) {
                    echo '<li><h5 class="card-title" style="color:white">'. "No." . $ranking++ . " " . ucfirst($finalResult[$i]["product_name"]) . ": " . $finalResult[$i]["average_rating"] . '</h5></a></li>';
                  }
                ?>
              </ul>
            </div>
          </div>

        </div>
      </div>
    
    
    
    <?php
      }
    ?>

      <div class="container">
        <div class="card-deck mb-3 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Toyota</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1000 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>10 users included</li>
                <li>2 GB of storage</li>
                <li>Email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/toyota.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Honda</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1500 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>20 users included</li>
                <li>10 GB of storage</li>
                <li>Priority email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/honda.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Chevrolet</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1200 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>30 users included</li>
                <li>15 GB of storage</li>
                <li>Phone and email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/chevrolet.php"> Click to see more</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="card-deck mb-3 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Ford</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1400 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>10 users included</li>
                <li>2 GB of storage</li>
                <li>Email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/ford.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Mercedes-Benz</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1500 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>20 users included</li>
                <li>10 GB of storage</li>
                <li>Priority email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/mercedesbenz.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Jeep</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$2200 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>30 users included</li>
                <li>15 GB of storage</li>
                <li>Phone and email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/jeep.php"> Click to see more</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="card-deck mb-3 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">BMW</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$2400 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>10 users included</li>
                <li>2 GB of storage</li>
                <li>Email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/bmw.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Porsche</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$3500 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>20 users included</li>
                <li>10 GB of storage</li>
                <li>Priority email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/porsche.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Subaru</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1400 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>30 users included</li>
                <li>15 GB of storage</li>
                <li>Phone and email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/subaru.php"> Click to see more</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="card-deck mb-3 text-center">
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Nissan</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$1200 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>10 users included</li>
                <li>2 GB of storage</li>
                <li>Email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/nissan.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Cadillac</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$2600 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>20 users included</li>
                <li>10 GB of storage</li>
                <li>Priority email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/cadillac.php"> Click to see more</a>
            </div>
          </div>
          <div class="card mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Volkswagen</h4>
            </div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$2000 <small class="text-muted">/ mo</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>30 users included</li>
                <li>15 GB of storage</li>
                <li>Phone and email support</li>
                <li>Help center access</li>
              </ul>
              <a type="button" class="btn btn-lg btn-block btn-primary" href="html/products/volkswagen.php"> Click to see more</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="card-deck mb-3 text-center">          
          <div class="card text-white bg-dark mb-4 box-shadow">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Last Visited 5 Products in the Past Hour</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled mt-3 mb-4">
                <?php 
                  foreach (array_reverse($lastVisits) as $key => $brand) {
                    $key++;
                    echo '<li><a href="html/products/' . $brand . '.php"><h5 class="card-title" style="color:white">' . $key . ". " . ucfirst($brand) . '</h5></a></li>';
                  }
                ?>
              </ul>
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
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

    <div class='container-md container-fluid mt-5 pt-3'>
      <h1 class="text-white">Visiting History <a href="manage.php"></a></h1>
      <table class='table table-light table-sm table-bordered table-hover table-striped table-responsive-md' id="listUl">
        <thead class="thead-dark align-middle">
          <tr> 
            <th  class='align-middle' scope="col"> Username </th> 
            <th  class='align-middle' scope="col"> Site </th> 
            <th  class='align-middle' scope="col"> Visit Time </th> 
          </tr>
        </thead>

        <?php
            $currentUsername = $_SESSION['UserData']['Username'];
            $postField = array('username' => $currentUsername);

            // First Post to My own's
            $url0 = "http://ryanhw.com/api/uservisiting.php";
            $url1 = "http://pichao314.com/trend.php";
            $url2 = "https://www.shengtao.website/company/api/site/user-last-visited.php";
            $url3 = "http://xunand.com/history.php";

            // Initiate curl
            $ch0 = curl_init($url0);
            $ch1 = curl_init($url1);
            $ch2 = curl_init($url2);
            $ch3 = curl_init($url3);

            // Will return the response, if false it print the response
            curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch0, CURLOPT_POSTFIELDS, $postField);
            
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $postField);
            
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $postField);

            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_POSTFIELDS, $postField);

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

            $result0 = json_decode($result0, true);
            $result1 = json_decode($result1, true);
            $result2 = json_decode($result2, true);
            $result3 = json_decode($result3, true);

            $finalResult = array_merge($result0, $result1);
            $finalResult = array_merge($finalResult, $result2);
            $finalResult = array_merge($finalResult, $result3);

            usort($finalResult, function ($value1, $value2) {
              return strcmp($value2['timestamp'], $value1['timestamp']);
            });

            for($i = 0 ; $i < count($finalResult); $i+=1) {
              echo '<tr>
                          <td class="align-middle">' . $currentUsername . '</td>
                          <td class="align-middle"><a href="' . $finalResult[$i]["url"] . '">' . ucfirst($finalResult[$i]["product_name"]) . '</a></td>
                          <td class="align-middle" style="width:150px">' .$finalResult[$i]["timestamp"]. '</td>
                    </tr>';
            }
          ?>
                  
      </table>
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
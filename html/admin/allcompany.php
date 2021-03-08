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
      <h1>All Company's User List <a href="manage.php"><span id="plusSign"><i class="fa fa-plus"></i></span></a></h1>
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
        <tr>
            <td class="align-middle" style="width:120px" colspan="6"><strong>Local User List of Company: HyperKar</strong></td>
        </tr>

        <?php
            $url = "http://ryanhw.com/api/userslist.php";
            // Initiate curl
            $ch = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$url);
            // Execute
            $result=curl_exec($ch);
            // Closing
            curl_close($ch);

            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($result, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST);
            
            foreach ($jsonIterator as $key => $val) {
                if($key === "first_name") {
                    $field1name = $val;
                }
                if($key === "last_name") {
                    $field2name = $val;
                }
                if($key === "email") {
                    $field3name = $val;
                }
                if($key === "home_phone") {
                    $field4name = $val;
                }
                if($key === "cell_phone") {
                    $field5name = $val; 
                }
                if($key === "home_address") {
                    $field6name = $val;
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
                  ?>
        
        <tr><td class="align-middle" style="width:120px" colspan="6"><strong></strong></td></tr>
        <tr><td class="align-middle" style="width:120px" colspan="6"><strong>Remote User List of Company: MusicLife</strong></td></tr>

        <?php
            $url3 = "http://xunand.com/otheruser.php";
            // Initiate curl
            $ch3 = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch3, CURLOPT_URL,$url3);
            // Execute
            $result3=curl_exec($ch3);
            // Closing
            curl_close($ch3);

            $jsonIterator3 = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($result3, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST);
            
            foreach ($jsonIterator3 as $key => $val) {
                if($key === "first_name") {
                    $field1 = $val;
                }
                if($key === "last_name") {
                    $field2 = $val;
                }
                if($key === "email") {
                    $field3 = $val;
                }
                if($key === "home_address") {
                    $field6 = $val;
                }
                if($key === "home_phone") {
                    $field4 = $val;
                }
                if($key === "cell_phone") {
                    $field5 = $val;
                    echo '<tr>
                    <td class="align-middle">' .$field1. '</td>
                    <td class="align-middle">' .$field2. '</td>
                    <td class="align-middle">' .$field3. '</td>
                    <td class="align-middle" style="width:120px">' .$field4. '</td>
                    <td class="align-middle" style="width:120px">' .$field5. '</td>
                    <td class="align-middle">' .$field6. '</td>
                    </tr>';
                }
            }
                  ?> 

        
        <tr><td class="align-middle" style="width:120px" colspan="6"><strong></strong></td></tr>
        <tr><td class="align-middle" style="width:120px" colspan="6"><strong>Remote User List of Company: Yu-Gi-Oh Cards</strong></td></tr>

        <?php
            $url2 = "https://www.shengtao.website/company/api/users.php";
            // Initiate curl
            $ch2 = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch2, CURLOPT_URL,$url2);
            // Execute
            $result2=curl_exec($ch2);
            // Closing
            curl_close($ch2);

            $jsonIterator2 = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($result2, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST);
            
            foreach ($jsonIterator2 as $key => $val) {
                if($key === "firstname") {
                    $field1 = $val;
                }
                if($key === "lastname") {
                    $field2 = $val;
                }
                if($key === "email") {
                    $field3 = $val;
                }
                if($key === "homephone") {
                    $field4 = $val;
                }
                if($key === "address") {
                    $field6 = $val;
                }
                if($key === "cellphone") {
                    $field5 = $val;
                    echo '<tr>
                    <td class="align-middle">' .$field1. '</td>
                    <td class="align-middle">' .$field2. '</td>
                    <td class="align-middle">' .$field3. '</td>
                    <td class="align-middle" style="width:120px">' .$field4. '</td>
                    <td class="align-middle" style="width:120px">' .$field5. '</td>
                    <td class="align-middle">' .$field6. '</td>
                    </tr>';
                }
            }
                  ?>
      </table>
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
<?php 
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

  $user_array = array();
  $query = "SELECT * FROM hyperkar.customers";
  // use exec() because no results are returned
  if($result = $conn->query($query)) {
      while($row = $result->fetch_assoc()) {
      $row_array["first_name"] = $row["first_name"];
      $row_array["last_name"] = $row["last_name"];
      $row_array["email"] = $row["email"];
      $row_array["home_phone"] = $row["home_phone"];
      $row_array["cell_phone"] = $row["cell_phone"]; 
      $row_array["home_address"] = $row["home_address"];
      array_push($user_array, $row_array);
      }
  }

    echo json_encode($user_array);
?>
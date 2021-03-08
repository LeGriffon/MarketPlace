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
    $top5VisitedQuery = "SELECT * FROM hyperkar.pageview ORDER BY count DESC LIMIT 5";
    if($result = $conn->query($top5VisitedQuery)) {
        while($row = $result->fetch_assoc()) {            
            $row_array["product_name"] = $row['product'];
            $row_array["count"] = $row['count'];
            array_push($user_array, $row_array);
        }
    }
    echo json_encode($user_array);


?>
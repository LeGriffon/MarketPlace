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

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user_array = array();
        $postusername = $_REQUEST['username'];
        if(!empty($postusername)){
            $userVisitingSearchQuery = "SELECT brand, url, time FROM hyperkar.users INNER JOIN hyperkar.visit_history ON users.id=visit_history.user_id AND users.username='$postusername' INNER JOIN hyperkar.products WHERE visit_history.product_id=products.id ORDER BY visit_history.time DESC";
            if($result = $conn->query($userVisitingSearchQuery)) {
                while($row = $result->fetch_assoc()) {
                    $row_array["product_name"] = $row['brand'];
                    $row_array["url"] = $row['url'];
                    $row_array["timestamp"] = $row['time'];
                    array_push($user_array, $row_array);
                }
                echo json_encode($user_array);
            }
            else {
                echo "No such username exists!";
            }
        }
        else {
            echo "Missing fileds of post request: username.";
        }
    }

?>
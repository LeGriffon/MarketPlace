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
        $postusername = $_REQUEST['username'];
        $postpassword = $_REQUEST['password'];
        if(!empty($postusername) && !empty($postpassword)){
            $userCreationQuery = "INSERT INTO hyperkar.users (username, password) VALUES ('$postusername', '$postpassword')";
            if($conn->query($userCreationQuery)) {
                $id = mysqli_insert_id($conn);
                $historyQuery = "INSERT INTO hyperkar.visit_history (user_id) VALUES ('$id')";
                $conn->query($historyQuery);

                $user_array = array();
                $row_array["username"] = $postusername;
                $row_array["password"] = $postpassword;
                array_push($user_array, $row_array);
                echo json_encode($user_array);
            }
            else {
                echo "Repeated username!";
            }
        }
        else {
            echo "Missing fileds with post request {username, password}.";
        }
    }

?>
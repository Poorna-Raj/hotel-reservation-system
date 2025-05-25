<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== "GET"){
            echo json_encode([
                "success" => false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }
        else{
            $userID = $_GET["user_id"] ?? "";
            $reservID = $_GET["reservation_id"] ?? "";
        }
        

        $sql = "SELECT * FROM reviews WHERE 1=1";
        $params = [];
        $dType = '';

        if(!empty($reservID)){
            $sql .= ' AND reservation_id = ?';
            $params[] = $reservID;
            $dType .= 'i';
        }
        if(!empty($userID)){
            $sql .= ' AND user_id = ?';
            $params[] = $userID;
            $dType .= 'i';
        }

        $stmt = $conn->prepare($sql);
        if(!empty($params)){
            $stmt->bind_param($dType,...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $review = [];

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $review[] = $row;
            }
            echo json_encode([
                "success"=> true,
                "data" => $review
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "No reviews to be found"
            ]);
        }
    }
    catch(mysqli_sql_exception $e){
        echo json_encode([
            "success"=> false,
            "message"=> $e->getMessage()
        ]);
    }
    finally{
        $conn->close();
        exit;
    }
?>
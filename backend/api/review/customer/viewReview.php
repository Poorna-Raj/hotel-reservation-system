<?php
    header("Content-type:application/json");
    include '../../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    session_start();

    try{
        if($_SERVER['REQUEST_METHOD'] !== "GET"){
            echo json_encode([
                "success" => false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }
        
        if(isset($_SESSION["user_id"]) and !empty($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "Unauthorized Access"
            ]);
            exit;
        }
        

        $sql = "SELECT * FROM reviews WHERE user_id = ? ORDER BY review_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$user_id);
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
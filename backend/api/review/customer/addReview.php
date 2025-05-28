<?php
    header("Content-type:application/json");
    include "../../../dbUtil.php";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    session_start();

    try{
        if ($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo json_encode([
                "success" => false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }
        if(isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])){
            $user_id = (int)$_SESSION['user_id'];
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'Unauthorized Access'
            ]);
            exit;
        }

        $data = Json_decode(file_get_contents("php://input"),true);
        if(isset($data["reservation_id"]) and !empty($data["reservation_id"])){
            $reservID = (int)$data["reservation_id"];
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "Reservation ID missing"
            ]);
            exit;
        }
        $rating = isset($data["rating"]) ? (int)$data["rating"] : 0;
        $comment = isset($data["comment"]) ? trim($data["comment"]) : "";

        $sql = "INSERT INTO reviews (reservation_id,user_id,rating,comment) VALUES (?,?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_Param("iiis", $reservID,$user_id,$rating,$comment);
        $stmt->execute();
        if($stmt->affected_rows === 1){
            $reviewSql = "UPDATE tblreservation SET has_reviewed = 1 WHERE id = ?;";
            $reviewStmt = $conn->prepare($reviewSql);
            $reviewStmt->bind_Param("i",$reservID);
            $reviewStmt->execute();
            if($reviewStmt->affected_rows === 1){
                echo json_encode([
                    "success"=> true,
                    "message"=> "Review recorded successfully"
                ]);
            }
            else{
                echo json_encode([
                    "success"=> false,
                    "message"=> "Reservation update failed"
                ]);
            }
        }
        else {
            echo json_encode([
                "success"=> false,
                "message"=> "Failed to record review. Try again."
            ]);
        }
        $stmt->close();
        $reviewStmt->close();
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
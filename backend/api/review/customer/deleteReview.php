<?php
    header("Content-type:application/json");
    include "../../../dbUtil.php";
    session_start();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo json_encode([
                "success" => false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }

        if(!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])){
            echo json_encode([
                "success"=> false,
                "message"=> "Unauthorized Access"
            ]);
            exit;
        }


        $data = json_decode(file_get_contents("php://input"),true);
        $reviewID = isset($data['review_id']) ? (int)$data['review_id'] :0;
        $reservationID = isset($data['reservation_id']) ? (int)$data['reservation_id'] :0;

        $sql = "DELETE FROM reviews WHERE review_id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reviewID);
        $stmt->execute();
        if($stmt->affected_rows === 1){
            $reviewSql = "UPDATE tblreservation SET has_reviewed = 0 WHERE id = ?;";
            $reviewStmt = $conn->prepare($reviewSql);
            $reviewStmt->bind_Param("i",$reservationID);
            $reviewStmt->execute();
            if($reviewStmt->affected_rows === 1){
                echo json_encode([
                    "success"=> true,
                    "message"=> "Review deleted successfully"
                ]);
            }
            else{
                echo json_encode([
                    "success"=> false,
                    "message"=> "Fail to update review status"
                ]);
            }
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "No reviews for provided id"
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
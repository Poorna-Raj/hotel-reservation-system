<?php
    header("Content-type:application/json");
    include "../../dbUtil.php";
    session_start();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if(!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])){
            echo json_encode([
                "success"=> false,
                "message"=> "Unauthorized Access"
            ]);
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo json_encode([
                "success"=> false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"),true);
        $user_id = isset($data["user_id"]) ? (int)$data["user_id"] :"";

        if(empty($user_id)){
            echo json_encode([
                "success"=> false,
                "message"=> "User ID missing"
            ]);
            exit;
        }

        $sql = "DELETE FROM tbluser WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        if($stmt->affected_rows === 1){
            echo json_encode([
                "success"=> true,
                "message"=> "User deleted successfully"
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "User cannot be found"
            ]);
        }
        $stmt->close();
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
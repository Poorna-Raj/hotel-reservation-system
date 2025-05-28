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

        if($_SERVER['REQUEST_METHOD']!== "GET"){
            echo json_encode([
                "success"=> false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }
        else{
            $email = isset($_GET['email']) ? trim($_GET['email']) : "";
            $role = isset($_GET["role"]) ? trim($_GET["role"]) : "";
        }

        $sql = "SELECT * FROM tbluser WHERE 1=1";
        $params = [];
        $dType = "";

        if(!empty($email)){
            $sql .= " AND email LIKE ?";
            $params[] = "%$email%";
            $dType .= "s";
        }
        if(!empty($role)){
            $sql .= " AND role = ?";
            $params[] = $role;
            $dType .= "s";
        }

        $stmt = $conn->prepare($sql);
        if(!empty($params)){
            $stmt->bind_param($dType,...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $user = [];

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $user[] = $row;
            }
            echo json_encode([
                "success"=> true,
                "data" => $user
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "No users to be found"
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
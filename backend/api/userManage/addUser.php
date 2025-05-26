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
        $email = isset($data["email"]) ? trim($data["email"]) :"";
        $password = isset($data["password"]) ? trim($data["password"]) :"";
        $role = isset($data["role"]) ? trim($data["role"]) :"";
        $active = isset($data["active"]) ? (int)($data["active"]) :"";

        if(empty($email) || empty($password) || empty($role) || !isset($active)){
            echo json_encode([
                "success"=> false,
                "message"=> "Missing Data"
            ]);
            exit;
        }
        $hashPassword = password_hash($password,PASSWORD_DEFAULT);

        $sql = "INSERT INTO tbluser (email,password,role,is_activated) VALUES (?,?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $email,$hashPassword,$role,$active);
        $stmt->execute();
        if($stmt->affected_rows === 1){
            echo json_encode([
                "success"=> true,
                "message"=> "User added successfully"
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "Something went wrong"
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
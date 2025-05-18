<?php
    session_start();
    header("Content-Type: application/json");
    include '../dbUtil.php';

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false, 
        "message" => "Invalid request method"
    ]);
    exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $username = trim($data['username']);
    $password = $data['password'];

    if(empty($username) || empty($password)){
        echo json_encode([
            "success"=> false,
            "message"=> "Please enter both username and password"
        ]);
        exit;
    }    

    $sql = "SELECT id,password,role,is_activated FROM tbluser WHERE email=?;";
    $stmt = $conn->prepare($sql);

    if($stmt === false){
        echo json_encode([
            "success" => false,
            "message" => "Database Error"
        ]);
        exit;
    }
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $row = $result->fetch_assoc();

        if($row['is_activated'] === 1){
            if(password_verify($password,$row['password'])){
                echo json_encode([
                    "success" => true,
                    "message" => "Login Successfull",
                    "role"=> $row["role"]
                ]);
            }
            else{
                echo json_encode([
                    "success"=> false,
                    "message"=> "Incorrect Password"
                ]);
            }
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "Account Inactivated! Please contact support."
            ]);
        }
    }
    else{
        echo json_encode([
            "success"=> false,
            "message"=> "Invalid User"
        ]);
    }
    $stmt->close();
    $conn->close();
    exit;
?>
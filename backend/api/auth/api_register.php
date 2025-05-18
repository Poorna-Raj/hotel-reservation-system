<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "success" => false, 
            "message" => "Invalid request method"
        ]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"),true);

    $email = trim($data['email']);
    $password = trim($data['password']);
    $hashPassword = password_hash($password,PASSWORD_DEFAULT);
    $fullName = trim($data['full_name']);
    $nic = trim($data['nic']);
    $tel = trim($data['tel_number']);
    $address = trim($data['address']);

    if(empty($email) || empty($password) || empty($fullName) || empty($nic) || empty($tel)){
        echo json_encode([
            'success' => false,
            'message' => 'Invalid user inputs'
        ]);
        exit;
    }

    $sqlUser = "INSERT INTO tbluser (email,password) VALUES (?,?);";
    $stmt = $conn->prepare($sqlUser);
    if(!$stmt){
        echo json_encode([
            'success' => false,
            'message' => 'Database Error'
        ]);
        exit;
    } 

    $stmt->bind_param("ss",$email,$hashPassword);
    if($stmt->execute()){
        $userId = $conn->insert_id;
        $stmt->close();

        $sql = "INSERT INTO tblcustomer (user_id,full_name,nic_number,tel_number,address) VALUES (?,?,?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss",$userId,$fullName,$nic,$tel,$address);

        if($stmt->execute()){
            echo json_encode([
                'success' => true,
                'message' => 'User created successfully'
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'Something went wrong'
            ]);
        }
    }
    else{
        echo json_encode([
            'success'=> false,
            'message'=> 'Something went wrong'
        ]);
    }

    $stmt->close();
    $conn->close();
    exit;
?>
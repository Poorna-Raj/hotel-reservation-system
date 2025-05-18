<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
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
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bind_param("ss",$email,$hashPassword);
        $stmtUser->execute();
        
        $userId = $conn->insert_id;
        $stmtUser->close();

        $sqlCus = "INSERT INTO tblcustomer (user_id,full_name,nic_number,tel_number,address) VALUES (?,?,?,?,?);";
        $stmtCus = $conn->prepare($sql);
        $stmtCus->bind_param("issss",$userId,$fullName,$nic,$tel,$address);
        $stmtCus->execute();
        $stmtCus->close();

        echo json_encode([
            'success' => true,
            'message' => 'User created successfully'
        ]);
    }
    catch(mysqli_sql_exception $e){
        if($e === 1062){
            echo json_encode([
                'success'=> false,
                'message'=> 'Email already in use'
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> $e->getMessage()
            ]);
        }
    }
    finally{
        $conn->close();
        exit;
    }
?>
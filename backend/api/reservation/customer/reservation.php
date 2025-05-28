<?php
    session_start();
    header("Content-type:application/json");
    include '../../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if(!isset($_SESSION['user_id'])){
            echo json_encode([
                'success' => false,
                'message'=> 'User id is missing'
            ]);
            exit;
        }
        $user = $_SESSION['user_id'];

        $sql = 'SELECT * FROM tblreservation WHERE customer_id = ? ORDER BY check_out_date DESC';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $reservation[] = $row;
            }
            echo json_encode([
                'success'=> true,
                'data' => $reservation
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'No reservation for the customer'
            ]);
        }
        $stmt->close();
    }
    catch(mysqli_sql_exception $e){
        echo json_encode([
            'success'=> false,
            'message'=> $e->getMessage()
        ]);
    }
    finally{
        $conn->close();
        exit;
    }
?>
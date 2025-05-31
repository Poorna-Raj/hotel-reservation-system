<?php
    header('Content-type:application/json');
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message'=> 'Invalid request method'
            ]);
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'),true);

        $customer_id = $data['customer_id'];
        $room_id = $data['roomID'];
        $inDate = $data['inDate'];
        $outDate = $data['outDate'];
        $numGuest = $data['num_of_guest'];
        $total = $data['total'];

        $checkSql = 'SELECT COUNT(*) FROM tblreservation 
             WHERE room_id = ? 
             AND check_out_date > ? 
             AND check_in_date < ?';
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param('iss', $room_id, $inDate, $outDate);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Room is already reserved during this time'
            ]);
            exit;
        }
        
        $sql = 'INSERT INTO tblreservation (customer_id,room_id,check_in_date,check_out_date,num_guest,total_amount) VALUES (?,?,?,?,?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iissid', $customer_id,$room_id, $inDate, $outDate, $numGuest, $total);
        $stmt->execute();
        if($stmt ->affected_rows === 1){
            $reservID = $conn->insert_id;
            echo json_encode([
                'success'=> true,
                'reservationID' => $reservID
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'Operation Failed'
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

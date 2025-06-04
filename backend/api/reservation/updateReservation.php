<?php
    header('Content-type:application/json');
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success'=> false,
                'message'=> 'Invalid request method'
            ]);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        $reservID = $data['reserveID'];
        $inDate = trim($data['inDate']);
        $outDate = trim($data['outDate']);
        $guests = $data['num_of_guest'];
        $total = $data['total'];
        $payStatus = $data['payStatus'];
        $reserveStatus = $data['reserveStatus'];

        $sql = 'UPDATE tblreservation SET 
                                    check_in_date = ?,
                                    check_out_date = ?,
                                    num_guest = ?,
                                    total_amount = ?,
                                    payment_status = ?,
                                    reservation_status = ?
                                    WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssidssi',$inDate,$outDate,$guests,$total,$payStatus,$reserveStatus,$reservID);
        $stmt->execute();
        if($stmt->affected_rows > 0){
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
<?php
    header('Content-type:application/json');
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message'=> 'Invalid Request Method'
            ]);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'),true);
        if(isset($data['reservationID']) && is_numeric($data['reservationID'])){
            $reservID = $data['reservationID'];
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'Reservation id missing'
            ]);
            exit;
        }

        $sql = 'DELETE FROM tblreservation WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $reservID);
        $stmt->execute();
        if($stmt->affected_rows >0){
            echo json_encode([
                'success'=> true,
                'message'=> 'Reservation removed successfully'
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
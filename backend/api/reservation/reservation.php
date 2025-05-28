<?php
    header("Content-type: application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== "GET"){
            echo json_encode([
                'success'=> false,
                'message'=> 'Incorrect Request'
            ]);
            exit;
        }
        else{
            $roomID = $_GET['roomID'] ?? '';
            $inDate = $_GET['inDate'] ?? '';
            $payStatus = $_GET['payStatus'] ?? '';
            $reservationStatus = $_GET['reservationStatus'] ?? '';
        }

        $sql = 'SELECT * FROM tblreservation WHERE 1=1';
        $params = [];
        $dtypes = '';
        if(!empty($roomID) && is_numeric($roomID)){
            $sql .= ' AND room_id = ?';
            $params[] = $roomID;
            $dtypes .= 'i';
        }
        if(!empty($inDate)){
            $sql .= ' AND check_in_date = ?';
            $params[] = $inDate;
            $dtypes .= 's';
        }
        if(!empty($payStatus)){
            $sql .= ' AND payment_status = ?';
            $params[] = $payStatus;
            $dtypes .= 's';
        }
        if(!empty($reservationStatus)){
            $sql .= ' AND reservation_status = ?';
            $params[] = $reservationStatus;
            $dtypes .= 's';
        }
        $stmt = $conn->prepare($sql);
        if(!empty($params)){
            $stmt->bind_param($dtypes, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $reservation = [];

        if($result->num_rows >= 0){
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
                'message'=> 'No Reservations to be found'
            ]);
        }
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
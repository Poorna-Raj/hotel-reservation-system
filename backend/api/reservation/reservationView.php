<?php
    header("Content-type: application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            echo json_encode([
                'success' => false,
                'message'=> 'Invalid request method'
            ]);
            exit;
        }
        else{
            $reservationID = $_GET['reserveID'];
        }

        $sql = 'SELECT * FROM tblreservation WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$reservationID);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1){
            $reservation = $result->fetch_assoc();
            echo json_encode([
                "success"=> true,
                "data" => $reservation
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "No reservation found with the provided ID!"
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
<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            echo json_encode([
                'success' => false,
                'message'=> 'Invalid request method. Only GET is allowed.'
            ]);
            exit;
        }
        else{
            $roomID = (int)$_GET['roomID'];
        }

        $sql = 'DELETE FROM tblroom WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $roomID);
        $stmt->execute();
        $stmt->close();

        echo json_encode([
            'success'=> true,
            'message'=> 'Room Deleted Successfully'
        ]);
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
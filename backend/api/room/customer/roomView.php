<?php
    header("Content-type:application/json");
    include '../../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            echo json_encode([
                'success' => false,
                'message'=> 'Incorrect Request'
            ]);
            exit;
        }
        else{
            $roomID = $_GET['id'] ?? '';
        }

        $sql = 'SELECT * FROM tblroom WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $roomID);
        $stmt->execute();
        $result = $stmt->get_result();

        $room = [];
        if($result->num_rows === 1){
            $room = $result->fetch_assoc();

            echo json_encode([
                'success'=> true,
                'data' => $room
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message'=> 'Room not found'
            ]);
        }
    }
    catch(mysqli_sql_exception $e){
        echo json_encode([
            'success'=> false,
            'message'=> $e->getMessage()
        ]);
    }
    catch(Exception $ex){
        echo json_encode([
            'success'=> false,
            'message'=> $ex->getMessage()
        ]);
    }
    finally{
        $conn->close();
        exit;
    }
?>
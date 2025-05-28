<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Incorrect Request'
            ]);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'),true);
        $room_name = trim($data['name']);
        $type = trim($data['type']);
        $price = (double)$data['price'];
        $bed_type = $data['bed_type'];
        $max_occupancy = (int)$data['occupancy'];
        $description = trim($data['description']);
        $short_description = trim($data['short_description']);
        $image_01 = $data['image1'];
        $image_02 = $data['image2'];
        $image_03 = $data['image3'];
        $status = $data['status'];

        $sql = 'INSERT INTO tblroom 
                (room_name,type,price,bed_type,max_occupancy,description,short_description,image_01,image_02,image_03,status)
                VALUES (?,?,?,?,?,?,?,?,?,?,?);';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsissssss",$room_name,$type,$price,$bed_type,$max_occupancy,$description,$short_description,$image_01,$image_02,$image_03,$status);
        $stmt->execute();
        $roomID = $conn->insert_id;
        $stmt->close();

        echo json_encode([
            'success' => true,
            'roomId' => $roomID
        ]);

    }
    catch(mysqli_sql_exception $e){
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    finally{
        $conn->close();
        exit;
    }
?>
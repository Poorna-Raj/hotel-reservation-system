<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message'=> 'Invalid request method. Only POST is allowed.'
            ]);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'),true);
        $roomID = $data['roomID'];
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

        $sql = "UPDATE tblroom SET
                    room_name = ?,
                    type = ?,
                    price = ?,
                    bed_type = ?,
                    max_occupancy = ?,
                    description = ?,
                    short_description = ?,
                    image_01 = ?,
                    image_02 = ?,
                    image_03 = ?,
                    status = ?
                    WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsissssssi", $room_name,$type,$price,$bed_type,$max_occupancy,$description,$short_description,$image_01,$image_02,$image_03,$status,$roomID);
        $stmt->execute();
        $stmt->close();

        echo json_encode([
            "success"=> true,
            "roomID" => $roomID
        ]);
    }
    catch(mysqli_sql_exception $e){
        echo json_encode([
            "success"=> false,
            "message" => $e->getMessage()
        ]);
    }
    finally{
        $conn->close();
        exit;
    }
?>
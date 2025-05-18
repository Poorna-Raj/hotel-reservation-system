<?php
    header("Content-type:application/json");
    include '../../dbUtil.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'GET'){
        echo json_encode([
            'success' => false,
            'message' => 'Invalid Request'
        ]);
        exit;
    }
    else{
        $name = $_GET['name'] ?? '';
        $type = $_GET['type'] ?? '';
        $bed_type = $_GET['bed_type'] ??'';
        $max_occupancy = $_GET['max_occupancy'] ??'';
        $orderBy = $_GET['orderBy'] ?? '';
    }

    $sql = "SELECT * FROM tblroom WHERE 1=1";
    $params = [];

    if(isset($name) && !empty(trim($name))){
        $sql .= ' AND room_name LIKE ?';
        $params[] = $name;
    }
    if(!empty($type)){
        $sql .= ' AND type = ?';
        $params[] = $type;
    }
    if(!empty($bed_type)){
        $sql .= ' AND bed_type = ?';
        $params[] = $bed_type;
    }
    if(!empty($max_occupancy)){
        $sql .= ' AND max_occupancy >= ?';
        $params[] = $max_occupancy;
    }
    if(!empty($orderBy)){
        if($orderBy === 'price_asc'){
            $sql .= ' ORDER BY price ASC';
        }
        else{
            $sql .= ' ORDER BY price DESC';
        }
    }
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        echo json_encode([
            'success'=> false,
            'message' => 'Database Error'
        ]);
        exit;
    }
    if(!empty($params)){
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    }
    if($stmt->execute()){
        $result = $stmt->get_result();
        $rooms = [];
        if($result->num_rows >= 0){
            while($row = $result->fetch_assoc()){
                $rooms[] = $row;
            }

            echo json_encode([
                'success'=> true,
                'data' => $rooms
            ]);
        }
        else{
            echo json_encode([
                'success'=> false,
                'message' => 'No rooms has been found'
            ]);
        }
    }
    else{
        echo json_encode([
            'success'=> false,
            'message' => 'Something went wrong'
        ]);
    }

    $stmt->close();
    $conn->close();
    exit;
?>
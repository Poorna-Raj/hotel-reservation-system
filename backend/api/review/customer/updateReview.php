<?php
    header("Content-type:application/json");
    include "../../../dbUtil.php";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            echo json_encode([
                "success"=> false,
                "message"=> "Invalid request method"
            ]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"),true);
        $reviewID = isset($data['review_id']) ? (int)$data['review_id'] :0;
        $rating = isset($data["rating"]) ? (int)$data["rating"] : 0;
        $comment = isset($data["comment"]) ? trim($data["comment"]) : "";

        $sql = "UPDATE reviews SET rating = ?,comment = ? WHERE review_id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $rating,$comment,$reviewID);
        $stmt->execute();

        if($stmt->affected_rows === 1){
            echo json_encode([
                "success"=> true,
                "message"=> "Review Update Successfully"
            ]);
        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=> "No review under given id"
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
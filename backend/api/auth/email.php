<?php
header("Content-Type: application/json");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "success" => false, 
            "message" => "Invalid request"
        ]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $name = trim($data['name']);
    $email = trim($data['email']);
    $message = trim($data['message']);

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    $to = "bandaraarosha29@gmail.com"; 
    $subject = "New Message from Contact Form";
    $body = "From: $name <$email>\n\nMessage:\n$message";

    if (mail($to, $subject, $body)) {
        echo json_encode([
            "success" => true
        ]);
    } else {
        echo json_encode([
            "success" => false, "message" => "Failed to send email."
        ]);
    }
} 
catch (Exception $e) {
    echo json_encode([
        "success" => false, 
        "message" => $e->getMessage()
    ]);
}

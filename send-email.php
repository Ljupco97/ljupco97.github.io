<?php
// Prevent direct access
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("HTTP/1.1 403 Forbidden");
    exit("Direct access not allowed");
}

// Set headers for JSON response
header('Content-Type: application/json');

// Get form data and sanitize
$name = strip_tags(trim($_POST["name"] ?? ""));
$email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$message = strip_tags(trim($_POST["message"] ?? ""));

// Validate inputs
if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Please fill in all fields correctly."]);
    exit;
}

// Set your email address where you want to receive messages
$recipient = "ljupcobogoevski97@gmail.com"; // ⚠️ CHANGE THIS TO YOUR EMAIL

// Set email subject
$subject = "New Contact Form Submission from $name";

// Build email content
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Build email headers
$email_headers = "From: $name <$email>\r\n";
$email_headers .= "Reply-To: $email\r\n";
$email_headers .= "X-Mailer: PHP/" . phpversion();

// Send the email
if (mail($recipient, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Thank you! Your message has been sent."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Oops! Something went wrong and we couldn't send your message."]);
}
?>

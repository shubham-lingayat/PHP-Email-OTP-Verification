<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//Load Composer's autoloader
require 'vendor/autoload.php';
$mail = new PHPMailer(true);

session_start();
function generateOtp() {
    // Generate a random number between 100000 and 999999
    $otp = random_int(100000, 999999);
    return $otp;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // Check if 'name' and 'email' keys exist in $_POST array
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $_SESSION['otp'] = generateOtp();
    $otp = $_SESSION['otp'];

} else {
    // If the form wasn't submitted, redirect to the form page
    // header("Loation: ./index.html");  
    echo "Error 101";
    exit();
}

try { 
    //Server settings
    $mail->SMTPDebug = false; //Enable verbose debug output (use-2)
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
 
    $mail->Username = 'shubh.lingayat2003@gmail.com';
    $mail->Password = 'wxuy mbnl asnv qctp'; 
    $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
    $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("shubh.lingayat2003@gmail.com", "GladOwl");
    $mail->addAddress($email, $name); //Name is optional
    // $mail->AddAddress('test@gmail.com', 'person-name');
 
    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Email Verification Mail From GladOwl';
    $mail->Body = "Hello $name, Your One Time Password is: $otp. Do not share with anyone"; 
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
    echo '<script> alert("Success");</script>'; 
    header("Location: ./index.html");
    // window.location.href="./index.html";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
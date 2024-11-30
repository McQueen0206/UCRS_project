<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
include("database2.php");

$student_id = $_GET['student_id'] ?? '';
$error = "";
$success = false;

if ($student_id) {
    $stmt = $con->prepare("SELECT * FROM student WHERE student_id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch();
        $email = $student['email'];
        $name = $student['name'];

        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Save new OTP
        $otp_sql = "INSERT INTO otp_verification (student_id, otp, expires_at) VALUES (:student_id, :otp, :expires_at)
                    ON DUPLICATE KEY UPDATE otp = :otp, expires_at = :expires_at";
        $otp_stmt = $con->prepare($otp_sql);
        $otp_stmt->bindParam(':student_id', $student_id);
        $otp_stmt->bindParam(':otp', $otp);
        $otp_stmt->bindParam(':expires_at', $expires_at);
        $otp_stmt->execute();

        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'afifsra3@gmail.com'; // Replace with your email
            $mail->Password   = 'aqyw scqh ozam hhon';  // Replace with your App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('afifsra3@gmail.com', 'UPTM Club Registration System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for UPTM Registration';
            $mail->Body    = "Hello $name,<br><br>Your OTP is: <b>$otp</b>.<br><br>Please use this OTP within 5 minutes to complete your registration.";

            $mail->send();
            header("Location: otp_verification.php?student_id=" . urlencode($student_id));
            exit;
        } catch (Exception $e) {
            $error = "Error sending OTP email: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Invalid student ID.";
    }
} else {
    $error = "No student ID provided.";
}
?>

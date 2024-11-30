<?PHP
session_start();
?>
<?PHP
// Include database connection
include("database.php");

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$success = "";
$error = "";

if ($act == "send_link") {
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';

    // Check if email exists in the database
    $SQL_check = "SELECT email FROM `student` WHERE email = '$email'";
    $result = mysqli_query($con, $SQL_check);

    if (mysqli_num_rows($result) > 0) {
        $encoded_email = base64_encode($email);
        $reset_link = "http://localhost/ucrs/passwordreset.php?secret=$encoded_email";

        $message = "
        <div>
            <p><b>Hello!</b></p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <br>
            <p><a href='$reset_link' class='btn btn-primary' style='text-decoration:none; color:white; background-color:blue; padding:10px; border-radius:5px;'>Reset Password</a></p>
            <br>
            <p>If you did not request a password reset, no further action is required.</p>
        </div>";

        // Configure and send the email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "afifsra3@gmail.com"; // Enter your email ID
            $mail->Password = "aqyw scqh ozam hhon"; // Enter your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom("afifsra3@gmail.com", "UPTM Club Registration System");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = $message;

            $mail->send();
            $success = "We have emailed your password reset link!";
        } catch (Exception $e) {
            $error = "Failed to send the password reset email. Error: " . $mail->ErrorInfo;
        }
    } else {
        $error = "We can't find a user with that email address.";
    }
}
?>
<!DOCTYPE html>
<html>
<title>UCRS - UPTM Club Registration System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body, h1, h2, h3, h4, h5, h6 {font-family: "Poppins", sans-serif;}
body, html {height: 100%; line-height: 1.8;}
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-image: url(images/banner.jpg);
  background-color: rgba(0, 0, 0, 0.5);
  background-blend-mode: overlay;
  background-attachment: fixed;
}
a:link {text-decoration: none;}
.w3-bar .w3-button {padding: 16px;}
</style>
<body class="bgimg-1">
<?PHP include("menu.php"); ?>

<div class="w3-padding-32"></div>

<!-- Toast Notification -->
<?PHP 
if ($success) {
    Notify("success", $success, "login.php"); // Assuming "login.php" is the intended redirect URL
}
if ($error) {
    Notify("error", $error, "reset.php"); // Redirect back to the reset page in case of error
}
?>


<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:500px">
        <div class="w3-padding">
            <div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:100px"></div>
            <hr style="margin :  0 0 0 0">
            <h3><b>Forgot Password</b></h3>
            
            <div class="w3-paddingx">
                <form action="" method="post">
                    <div class="w3-section">
                        <input class="w3-padding w3-input w3-border w3-round" type="email" name="email" placeholder="Email *" required>
                    </div>
                    <input name="act" type="hidden" value="send_link">
                    <button type="submit" class="w3-wide w3-button w3-block w3-padding-large w3-blue w3-round">
                        <b><i class="fas fa-paper-plane"></i> SEND RESET LINK</b>
                    </button>
                </form>
            </div>
            
            <div class="w3-center w3-padding">Remember your password? <a href="login.php" class="w3-text-indigo">Login</a></div>
        </div>      
    </div>
</div>

<div class="w3-padding-small"></div>
<script>
// Toggle sidebar
var mySidebar = document.getElementById("mySidebar");
function w3_open() { mySidebar.style.display = mySidebar.style.display === 'block' ? 'none' : 'block'; }
function w3_close() { mySidebar.style.display = "none"; }
</script>
</body>
</html>

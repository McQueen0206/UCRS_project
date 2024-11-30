<?PHP

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
date_default_timezone_set('Asia/Kuala_Lumpur'); // Replace with your correct timezone


include("database2.php");

$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';
$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$student_id = (isset($_POST['student_id'])) ? trim($_POST['student_id']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$year_study = (isset($_POST['year_study'])) ? trim($_POST['year_study']) : '';
$course 	= (isset($_POST['course'])) ? trim($_POST['course']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';

//$name		=	mysqli_real_escape_string($con, $name);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$error = "";
$success = false;

if ($act == "register") {
    $check_sql = "SELECT * FROM student WHERE student_id = :student_id";
    $check_stmt = $con->prepare($check_sql);
    $check_stmt->bindParam(':student_id', $student_id);
    $check_stmt->execute();
    if ($check_stmt->rowCount() > 0) {
        $error = "Student ID already registered";
    } else {
        $otp = rand(100000, 999999);

        // Insert user into database
        $sql = "INSERT INTO student (name, student_id, password, email, phone, year_study, course)
                VALUES (:name, :student_id, :password, :email, :phone, :year_study, :course)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':year_study', $year_study);
        $stmt->bindParam(':course', $course);

        if ($stmt->execute()) {
            // Save OTP in the database
			$expires_at = date("Y-m-d H:i:s", strtotime("+3 minutes")); // Set expiration to 3 minutes from now
$otp_sql = "INSERT INTO otp_verification (student_id, otp, expires_at) VALUES (:student_id, :otp, :expires_at)";
$otp_stmt = $con->prepare($otp_sql);
$otp_stmt->bindParam(':student_id', $student_id);
$otp_stmt->bindParam(':otp', $otp);
$otp_stmt->bindParam(':expires_at', $expires_at);
$otp_stmt->execute();



            // Send OTP email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'afifsra3@gmail.com'; // Replace with your email
                $mail->Password   = 'aqyw scqh ozam hhon';    // Replace with your app password
                $mail->SMTPSecure = 'tls';                  // Use 'tls' or 'ssl'
                $mail->Port       = 587;

                $mail->setFrom('afifsra3@gmail.com', 'UPTM Registration');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for UPTM Registration';
                $mail->Body    = "Hello $name,<br><br>Your OTP for registration is: <b>$otp</b>.<br><br>Please use this OTP to complete your registration.";

                $mail->send();
                header("Location: otp_verification.php?student_id=" . urlencode($student_id) . "&success=1");
exit;

                exit;
            } catch (Exception $e) {
                $error = "Error sending OTP email: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Error: Could not register user.";
        }
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
body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-image: url(images/banner.jpg);
  background-color: rgba(0, 0, 0, 0.5);
  background-blend-mode: overlay;
  background-attachment:fixed;
}

a:link {
  text-decoration: none;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="bgimg-1">

<?PHP include("menu.php"); ?>


<div  >

<div class="w3-padding-48"></div>

<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:500px">
		<div class="w3-padding">
			<form action="" method="post">

			<div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:100px"></div>
				<hr style="margin : 0 0 0 0">
				<h3><b>Sign Up Student</b></h3>
			
			<?PHP if($error) { ?>			
			<div class="w3-padding-16" id="contact">
				<div class="w3-red w3-animate-zoom" style="max-width:600px">
					<div class="w3-padding w3-center">
					<h3>Error! </h3>
					<p><?PHP echo $error;?></p>
					</div>
				</div>
			</div>	
			<?PHP } ?>

			<?PHP if($success) { ?>
			<div class="w3-green w3-animate-zoom">
			  <div class="w3-padding w3-center">
				<h3>Congratulation!</h3>
				<p>Your registration is successful. </p>
			  </div>
			</div>
			<?PHP  } else { ?>				
			  
				<div class="w3-section" >			
					<input class="w3-input w3-border w3-round" type="text" name="name"  placeholder="Full Name *" required>
				</div>

				<div class="w3-section">
					<input class="w3-input w3-border w3-round" type="email" name="email" placeholder="Email *" required>
				</div>

				<div class="w3-section" >			
					<input class="w3-input w3-border w3-round" type="text" name="phone"  placeholder="Phone *" required>
				</div>

				<div class="w3-section" >			
					<input class="w3-input w3-border w3-round" type="number" name="year_study"  placeholder="Year Of Study *" required>
				</div>

				<div class="w3-section" >			
					<input class="w3-input w3-border w3-round" type="text" name="course"  placeholder="Course *" required>
				</div>

				<div class="w3-section" >			
					<input class="w3-input w3-border w3-round" type="text" name="student_id"  placeholder="Student ID *" required>
				</div>

				<div class="w3-section" >
					<input class="w3-input w3-border w3-round" type="password" name="password" id="password" placeholder="Password *" required>
					<div class="w3-padding w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
				</div>
			  
			    <script>
				function myFunction() {
				  var x = document.getElementById("password");
				  if (x.type === "password") {
					x.type = "text";
				  } else {
					x.type = "password";
				  }
				}
				</script>
	
			  <input name="act" type="hidden" value="register">
			  <button type="submit" class="w3-wide w3-button w3-block w3-padding-large w3-indigo w3-round"><b>REGISTER</b></button>				  
			<?PHP } ?>

			</form>
			
		</div>
		
		<div class="w3-center w3-padding">Already have account? <a href="login.php" class="w3-text-indigo">Login</a></div>
		
    </div>
</div>

<div class="w3-padding-16"></div>
	
</div>

	
 
<script>

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>

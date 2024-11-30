<?PHP
session_start();
include("database2.php");

$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$error = "";

$success = isset($_GET['success']) && $_GET['success'] == 1; 

if($act == "login") 
{
	$student_id = (isset($_POST['student_id'])) ? trim($_POST['student_id']) : '';
	$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
	$role 		= (isset($_POST['role'])) ? trim($_POST['role']) : '';

	if (empty($student_id) || empty($password)) {
		$error = "Please fill all the required fields.";
    }
	
	$sql = "SELECT * FROM `$role` WHERE student_id = :student_id ";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {		
		    $_SESSION['student_id'] = $user['student_id'];
			$_SESSION["password"] 	= $user['password'];	

            if ($role == "student") {
				$_SESSION['id_student'] = $user['id_student'];
				echo '<script>window.location = "main.php";</script>';
            } elseif ($role == "president") {
                $_SESSION['id_president'] = $user['id_president'];
				echo '<script>window.location = "p-main.php";</script>';
            }
            exit();
        } else {
			$error = "Invalid Login";
            echo "<script>window.location = 'login.php';</script>";
        }
    } else {
        $error = "User not registered";
		header( "refresh:1;url=login.php" );
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

a:link {
  text-decoration: none;
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

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="bgimg-1">

<?PHP include("menu.php"); ?>


<div class="w3-padding-32"></div>
		
<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
		<div class="w3-padding">
			<form action="" method="post">
				<div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:100px"></div>
				<hr style="margin : 0 0 0 0">
				<h3><b>Sign In Login</b></h3>
				
				<?PHP if($error) { ?>			
					<div class="w3-content w3-container w3-red w3-round w3-card">
						<div class="w3-padding w3-center">
						<h3>Error! <?PHP echo $error;?></h3>
						<p>Please try again...</p>
						</div>
					</div>
				<?PHP } ?>
				
				
				<div class="w3-section" >
					<input class="w3-input w3-border w3-round" type="text" name="student_id" placeholder="Student ID *" required>
				</div>
				<div class="w3-section">
					<input class="w3-input w3-border w3-round" type="password" name="password" id="password" placeholder="Password *" required>
					<div class="w3-padding-small w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
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
				
				<div class="w3-section">
					<small class="w3-text-grey">Role</small>
					<select class="w3-select w3-border w3-round w3-padding" name="role" id="role" required>
						<option value="student" >Student</option>
						<option value="president" >Club President </option>
					</select>
				</div>
			
				<input name="act" type="hidden" value="login">
				<button type="submit" class="w3-wide w3-text-white w3-button w3-block w3-padding-large w3-indigo w3-margin-bottom w3-round"><b>SIGN IN</b></button>
			</form>
			
			<div class="w3-center w3-paddingx">No account yet? <a href="register.php" class="w3-text-indigo">Register Here</a> | <a href="reset.php" class="w3-text-indigo">Forgot Password</a></div>
		</div>
		
    </div>
</div>

</div>
				
		<div class="w3-padding-16"></div>
		
    </div>
</div>

<div class="w3-padding-64"></div>

	
</div>


<div class="w3-bottom">

<?PHP include("footer.php");?>
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

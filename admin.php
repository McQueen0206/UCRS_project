<?PHP
session_start();
include("database.php");
$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$error = "";

if($act == "login") 
{
	$username 	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
	$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
	$password 	= md5($password);
	
	$SQL_login 	= " SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'  ";
	$result 	= mysqli_query($con, $SQL_login);
	$data		= mysqli_fetch_array($result);
	$valid 	= mysqli_num_rows($result);

	if($valid > 0)
	{
		$_SESSION["id_admin"] 	= $data["id_admin"];
		$_SESSION["username"] 	= $username;
		$_SESSION["password"] 	= $password;	

		header("Location:a-main.php");

	}else{
		$error = "Invalid";
		header( "refresh:1;url=admin.php" );
		//print "<script>alert('Invalid Login!'); self.location='index.php';</script>";
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
  background-attachment:fixed;
  background-image: url(images/banner.jpg);
  min-height:100%;
  background-color: rgba(0, 0, 0, 0.5);
  background-blend-mode: overlay;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="bgimg-1">

<?PHP include("menu.php"); ?>

<div class="w3-padding-48"></div>

<div  >

		
<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:500px">
		<div class="w3-padding">
			<form action="" method="post">
				<div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:100px"></div>
				<hr style="margin : 0 0 0 0">
				<h3><b>Sign In Admin</b></h3>
				
				<?PHP if($error) { ?>			
				<div class="w3-container w3-padding-32" id="contact">
					<div class="w3-content w3-container w3-red w3-round w3-card" style="max-width:600px">
						<div class="w3-padding w3-center">
						<h3>Error! <?PHP echo $error;?></h3>
						<p>Please try again...</p>
						</div>
					</div>
				</div>	
				<?PHP } ?>
				
				
				<div class="w3-section" >
					<label>Username *</label>
					<input class="w3-input w3-border w3-round" type="text" name="username"  required>
				</div>
				<div class="w3-section">
					<label>Password *</label>
					<input class="w3-input w3-border w3-round" type="password" name="password" id="password" required>
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
	
				<input name="act" type="hidden" value="login">
				<button type="submit" class="w3-wide w3-text-white w3-button w3-block w3-padding-large w3-indigo w3-margin-bottom w3-round"><b>SIGN IN</b></button>
			</form>					
			
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

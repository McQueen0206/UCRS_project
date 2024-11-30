<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_admin	= $_SESSION["id_admin"];

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$username 	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$password 	= md5($password);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`admin`
	SET
		`username` = '$username',
		`password` = '$password'
	WHERE
		`id_admin`='$id_admin' 
		";
	
	$result = mysqli_query($con, $SQL_update);

	$success = "Successfully Updated";
	//print "<script>self.location='a-profile.php';</script>";
}

$SQL_list = "SELECT * FROM `admin` WHERE `id_admin` = $id_admin";
$result = mysqli_query($con, $SQL_list) ;
$data	= mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>UCRS - UPTM Club Registration System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Poppins",  sans-serif}
a:link {
  text-decoration: none;
}
.w3-bar-block .w3-bar-item {padding: 16px}
.w3-biru {background-color:#f6f9ff;}
.w3-ungu {background-color:#979df9;}
</style>
</head>
<body class="w3-biru">

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-profile.php"); }
?>	

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="a-main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding" style="width:200px;"></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>

	<a href="a-main.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>

	<a href="a-student.php" class="w3-bar-item w3-button">
	<i class="far fa-fw fa-user w3-margin-right"></i> Student</a>

	<a href="a-president.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-user-tie w3-margin-right"></i> President</a>
	
	<a href="a-club.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-list w3-margin-right"></i> Club</a>
	
	<a href="a-report.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-file-alt w3-margin-right"></i> Report</a>
	
	<div class="w3-bar-item w3-bottom w3-small">ver1.0</div>
</nav>



<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div class="w3-main" style="margin-left:250px;">



<div class="w3-white w3-bar w3-card ">


	<i class="fa fa-bars w3-buttonx w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i>

	
	<div class="w3-large w3-buttonx w3-bar-item w3-right w3-white w3-dropdown-hover">
      <button class="w3-button"><i class="fa fa-fw fa-user-circle"></i> Admin <i class="fa fa-fw fa-chevron-down w3-small"></i></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="a-profile.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-user-cog "></i> Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-sign-out-alt "></i> Logout</a>
      </div>
    </div>

</div>

<div class="w3-padding-32"></div>
	
<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-white w3-content w3-card w3-padding-16" style="max-width:600px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-padding">
	  
		<form action="" method="post" >
			<div class="w3-padding">
			<b class="w3-large">Admin Profile</b>
			<hr>
						
				<div class="w3-section" >					
					Email *
					<input class="w3-input w3-border w3-round w3-padding" type="text" name="username" value="<?PHP echo $data["username"]; ?>" placeholder="Email" required>
				</div>
			  
				<div class="w3-section">
					Password *
					<input class="w3-input w3-border w3-round w3-padding" type="password" name="password" value="" required>
				</div>
			    
			<hr class="w3-clear">
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-black w3-round">Save Changes</button>
			
			</div>  
		</form>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	
	

</div>
<!-- container end -->


<div class="w3-padding-24"></div>

     
</div>

	
<script>
var openInbox = document.getElementById("myBtn");
openInbox.click();

function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

function myFunc(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show"; 
    x.previousElementSibling.className += " w3-pale-red";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-red", "");
  }
}

</script>

</body>
</html> 

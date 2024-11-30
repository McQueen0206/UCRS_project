<?PHP
session_start();

include("database.php");
if( !verifyPresident($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_president	= $_SESSION["id_president"];
$act		= (isset($_POST['act'])) ? trim($_POST['act']) : '';	

$id_club	= (isset($_POST['id_club'])) ? trim($_POST['id_club']) : '';
$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$student_id = (isset($_POST['student_id'])) ? trim($_POST['student_id']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$course 	= (isset($_POST['course'])) ? trim($_POST['course']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';

$name		=	mysqli_real_escape_string($con, $name);
$course		=	mysqli_real_escape_string($con, $course);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE `president` SET 
		`id_club` = '$id_club',
		`name` = '$name',
		`student_id` = '$student_id',
		`password` = '$password',
		`email` = '$email',
		`phone` = '$phone',
		`course` = '$course'
	WHERE 
		`id_president` =  $id_president";	
										
	$result = mysqli_query($con, $SQL_update);
	
	$success = "Successfully Updated";
	//print "<script>alert('Successfully Updated!');</script>";
}

$sql_stu 	= " SELECT * FROM `president` WHERE `id_president` =  $id_president";
$rst_stu 	= mysqli_query($con, $sql_stu);
$data		= mysqli_fetch_array($rst_stu);
$name		= $data["name"];
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
html,body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
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
if($success) { Notify("success", $success, "p-profile.php"); }
?>	

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="p-main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding" style="width:200px;"></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>

	<a href="p-main.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>

	<a href="p-club.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-info-circle w3-margin-right"></i> Club Profile</a>

	<a href="p-member.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-user-tie w3-margin-right"></i> Member</a>
	
	<a href="p-event.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-list w3-margin-right"></i> Event</a>
	
	<a href="p-announcement.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-bullhorn w3-margin-right"></i> Announcement</a>
	
	<div class="w3-bar-item w3-bottom w3-small">ver1.0</div>
</nav>


<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div class="w3-main" style="margin-left:250px;">

<div class="w3-white w3-bar w3-card ">

	<i class="fa fa-bars w3-buttonx w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i>
	
	<div class="w3-large w3-buttonx w3-bar-item w3-right w3-white w3-dropdown-hover">
      <button class="w3-button"><i class="fa fa-fw fa-user-circle"></i> President <i class="fa fa-fw fa-chevron-down w3-small"></i></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="p-profile.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-user-cog "></i> Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-sign-out-alt "></i> Logout</a>
      </div>
    </div>

</div>

<div class="w3-padding-32"></div>

<div class="w3-container w3-content " style="max-width:600px;">  
  
	<form action="" method="post">
	<div class="w3-padding-16 w3-padding w3-card w3-white">
		
		<div class="">
		<div class="w3-padding">
			<b class="w3-large">Your Profile</b>
			<hr>
			 		  
				<div class="w3-section" >
					Club *
					<select class="w3-select w3-border w3-round w3-padding" name="id_club" required>
						<option value="">- Select - </option>
					<?PHP 
					$rst = mysqli_query($con , "SELECT * FROM `club`");
					while ($dat = mysqli_fetch_array($rst) )
					{
					?>
						<option value="<?PHP echo $dat["id_club"];?>" <?PHP if($data["id_club"] == $dat["id_club"]) echo "selected";?>><?PHP echo $dat["club_name"];?></option>
					<?PHP } ?>
					</select>
				</div>
					
				<div class="w3-section" >					
					Name *
					<input class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Student ID *
					<input class="w3-input w3-border w3-round" type="text" name="student_id" value="<?PHP echo $data["student_id"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Password *
					<input class="w3-input w3-border w3-round" type="password" name="password" value="<?PHP echo $data["password"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Email *
					<input class="w3-input w3-border w3-round" type="email" name="email" value="<?PHP echo $data["email"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Phone *
					<input class="w3-input w3-border w3-round" type="text" name="phone" value="<?PHP echo $data["phone"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Course *
					<input class="w3-input w3-border w3-round" type="text" name="course" value="<?PHP echo $data["course"]; ?>" placeholder="" required>
				</div>
			
			<hr>

			<div class="w3-section" >
				<input name="id_president" type="hidden" value="<?PHP echo $id_president;?>">
				<input name="act" type="hidden" value="edit">
				<button type="submit" class="w3-button w3-padding-large w3-indigo w3-round">SAVE CHANGES</button>
			</div>		
		
		</div>
		</div>
		
	</div>
	</form>

</div>
	

	

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
    x.previousElementSibling.className += " w3-red";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-red", "");
  }
}

</script>

</body>
</html> 

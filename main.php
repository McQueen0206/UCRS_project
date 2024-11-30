<?PHP
session_start();

include("database.php");
if( !verifyStudent($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP 
$id_student	= $_SESSION["id_student"];

$sql_stu 	= " SELECT * FROM `student` WHERE `id_student` =  $id_student";
$rst_stu 	= mysqli_query($con, $sql_stu);
$dat_stu	= mysqli_fetch_array($rst_stu);
$name		= $dat_stu["name"];
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
<link href="css/table.css" rel="stylesheet" />

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

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding w3-image" ></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-fw fa-times"></i></a>
	
	<a href="main.php" class="w3-bar-item w3-button w3-white">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>
	
	<a href="club.php" class="w3-bar-item w3-button ">
	<i class="fa fa-fw fa-info-circle w3-margin-right"></i> Club</a>
	
	<a href="event.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-tasks w3-margin-right"></i> Event</a>
	
	<div class="w3-bar-item w3-bottom w3-small">ver1.0</div>
</nav>


<!-- Overlay effect when opening the side navigation on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Close Sidemenu" id="myOverlay"></div>

<!-- Page content -->
<div class="w3-main" style="margin-left:250px;">

<div class="w3-white w3-bar w3-card ">

	<i class="fa fa-bars w3-buttonx w3-white w3-hide-large w3-xlarge w3-margin-left w3-margin-top" onclick="w3_open()"></i>
	
	<div class="w3-large w3-buttonx w3-bar-item w3-right w3-white w3-dropdown-hover">
      <button class="w3-button"><i class="fa fa-fw fa-user-circle"></i> Student <i class="fa fa-fw fa-chevron-down w3-small"></i></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="profile.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-user-cog "></i> Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-sign-out-alt "></i> Logout</a>
      </div>
    </div>

</div>

<div class="w3-padding-32"></div>

<div class="w3-content w3-xlarge w3-margin-bottom" style="max-width:1000px;"><b>Welcome back, <?PHP echo $name;?></b></div>
	
<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-content w3-padding-16 " style="max-width:1000px;">
		<!-- The Grid -->
		<div class="" style="max-width:800px;">

			<div class="">
				<div class="w3-card w3-border w3-white w3-round-large w3-padding w3-padding-16">
				<div class="w3-large"><i class="fa fa-fw fa-bullhorn w3-margin-right"></i> <b> Announcement</b></div>
				<hr>

				<?PHP
				$SQL_list = "SELECT * FROM `announcement`";
				$result = mysqli_query($con, $SQL_list) ;
				while ( $data	= mysqli_fetch_array($result) )
				{
					$title	= $data["title"];
					$announcement	= $data["announcement"];
					$created_date	= $data["created_date"];
				?>	

				<div class="w3-padding-16">
					<div class="w3-right"><?PHP echo $created_date;?></div>
					<div class=""><b><?PHP echo $title;?></b></div>
					<p><?PHP echo $announcement;?></p>
				</div>
				<?PHP } ?>
				
				</div>
			</div>
				
			
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

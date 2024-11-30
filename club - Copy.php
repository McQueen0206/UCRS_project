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

$act 			= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_club		= (isset($_REQUEST['id_club'])) ? trim($_REQUEST['id_club']) : '';	

$error = "";
$success = "";

if($act == "join")
{	
	$SQL_insert = "INSERT INTO `member`(`id_member`, `id_club`, `id_student`) VALUES (NULL,'$id_club','$id_student')";	

	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully join";
}

function AlreadyJoin($con, $id_club, $id_student){
	$tot_found = numRows($con, "SELECT * FROM `member` WHERE id_club = $id_club AND id_student = $id_student");
	if($tot_found > 0)
		return TRUE;
	else
		return FALSE;
}
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
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
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
if($success) { Notify("success", $success, "club.php"); }
?>	

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding w3-image" ></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-fw fa-times"></i></a>
	
	<a href="main.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>
	
	<a href="club.php" class="w3-bar-item w3-button w3-white">
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

<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-content w3-white w3-card w3-padding-16 w3-round" style="max-width:1000px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-padding">		
		
		<div class="w3-large"><b>All Club</b></div>

		<hr>
		
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
			<thead>
			<tr>
				<th>#</th>
				<th>Logo</th>
				<th>Club Name</th>
				<th>Description</th>
				<th>Year Established</th>
				<th>Action</th>
			</tr>
			</thead>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `club`";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_club	= $data["id_club"];
				$logo	= $data["logo"];
				if(!$logo)  $logo = "noimage.jpg";	
				
				$isjoin = AlreadyJoin($con, $id_club, $id_student);
			?>
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><img src="upload/<?PHP echo $logo; ?>" class="w3-round-large w3-image" alt="image" style="width:100%;max-width:60px"></td>
				<td><?PHP echo $data["club_name"];?></td>
				<td><?PHP echo substrwords($data["description"], 80, '...');?></td>
				<td><?PHP echo $data["year_est"];?></td>																			
				<td>
				<?PHP if($isjoin ==0) { ?>
					<a href="#" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-blue">Join</a>
				<?PHP } else { ?>
					<a href="#" class="w3-button w3-disabled w3-blue">Already Joined</a>
				<?PHP } ?>
				</td>
				
			</tr>	


<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Confirmation</b>
			  
			<hr class="w3-clear">			
			Are you sure to join this club ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_club" value="<?PHP echo $data["id_club"];?>" >
			<input type="hidden" name="act" value="join" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-black w3-margin-bottom w3-round">Cancel</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-margin-bottom w3-round">Yes, Confirm</button>

		</form>
		</div>
	</div>
</div>	
			<?PHP } ?>
		</table>
		</div>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	
	

</div>
<!-- container end -->
	

<div class="w3-padding-24"></div>

     
</div>


<div class="w3-padding-16"></div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<!--<script src="assets/demo/datatables-demo.js"></script>-->

<script>
$(document).ready(function() {

  
	$('#dataTable1').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
});
</script>


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

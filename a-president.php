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
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_president	= (isset($_REQUEST['id_president'])) ? trim($_REQUEST['id_president']) : '';	

$id_club	= (isset($_POST['id_club'])) ? trim($_POST['id_club']) : '';
$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$student_id = (isset($_POST['student_id'])) ? trim($_POST['student_id']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$course 	= (isset($_POST['course'])) ? trim($_POST['course']) : '';
$phone 		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';

$name		=	mysqli_real_escape_string($con, $name);
$course		=	mysqli_real_escape_string($con, $course);

$error = "";
$success = "";

if($act == "add")
{	
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
	$SQL_insert = " 		
		INSERT INTO `president`(`id_president`, `id_club`, `name`, `student_id`, `password`, `email`, `phone`, `course`) 
				VALUES (NULL, '$id_club', '$name', '$student_id', '$hashed_password', '$email', '$phone', '$course')
	";	

	$result = mysqli_query($con, $SQL_insert);
	$success = "Successfully registered";
}


if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`president`
	SET	
		`id_club` = '$id_club',
		`name` = '$name',
		`student_id` = '$student_id',
		`email` = '$email',
		`phone` = '$phone',
		`course` = '$course'
	WHERE
		id_president = $id_president
	";
										
	$result = mysqli_query($con, $SQL_update);
	
	$success = "Successfully Updated";
	
	//print "<script>self.location='president.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `president` WHERE `id_president` =  '$id_president' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='president.php';</script>";
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
if($success) { Notify("success", $success, "a-president.php"); }
?>	

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="a-main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding" style="width:200px;"></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>

	<a href="a-main.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>

	<a href="a-student.php" class="w3-bar-item w3-button">
	<i class="far fa-fw fa-user w3-margin-right"></i> Student</a>

	<a href="a-president.php" class="w3-bar-item w3-button w3-white">
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
	<div class="w3-container w3-content w3-white w3-card w3-padding-16 w3-round" style="max-width:1000px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-padding">		
		
		<a onclick="document.getElementById('add01').style.display='block'; " class="w3-margin-bottom w3-right w3-button w3-black w3-round "><i class="fa fa-fw fa-lg fa-plus"></i> Add New</a>
		<div class="w3-large"><b>All President</b></div>

		<hr>
		
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
			<thead>
			<tr>
				<th>#</th>
				<th>Club</th>
				<th>Name</th>
				<th>Student ID</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Course</th>
				<th>Action</th>
			</tr>
			</thead>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `president`,`club` WHERE president.id_club = club.id_club";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_president	= $data["id_president"];
			?>
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["club_name"];?></td>
				<td><?PHP echo $data["name"];?></td>
				<td><?PHP echo $data["student_id"];?></td>
				<td><?PHP echo $data["email"];?></td>												
				<td><?PHP echo $data["phone"];?></td>																							
				<td><?PHP echo $data["course"];?></td>												
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class="w3-hover-grey w3-padding-small w3-text-indigo"><i class="fas fa-edit"></i></a>
				<a href="#" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-hover-grey w3-padding-small w3-text-red"><i class="fas fa-trash-alt"></i></a>
				</td>
				
			</tr>	
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
			<form action="" method="post" class="w3-padding">
				<div class="w3-padding"></div>
				<b class="w3-large">Update Student</b>
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
				
				<!--
				<div class="w3-section" >					
					Password *
					<input class="w3-input w3-border w3-round" type="password" name="password" id="password" value="<?PHP echo $data["password"]; ?>" placeholder="" required>
					<div class="w3-padding-small w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
				</div>
				-->
				
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
			  
				<hr class="w3-clear">
				<input type="hidden" name="id_president" value="<?PHP echo $data["id_president"];?>" >
				<input type="hidden" name="act" value="edit" >
				<button type="submit" class="w3-button w3-black w3-margin-bottom w3-round">Save Changes</button>

			</form>
		</div>
	</div>
</div>

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
			Are you sure to delete this record ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_president" value="<?PHP echo $data["id_president"];?>" >
			<input type="hidden" name="act" value="del" >
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


<div id="add01" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('add01').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
	  
      <div class="w3-container w3-padding">
		
		<form action="" method="post" class="w3-padding">
			<div class="w3-padding"></div>
			<b class="w3-large">Add President</b>
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
						<option value="<?PHP echo $dat["id_club"];?>" ><?PHP echo $dat["club_name"];?></option>
					<?PHP } ?>
					</select>
				</div>
				
				<div class="w3-section" >					
					Name *
					<input class="w3-input w3-border w3-round" type="text" name="name" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Student ID *
					<input class="w3-input w3-border w3-round" type="text" name="student_id" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Password *
					<input class="w3-input w3-border w3-round" type="password" name="password" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Email *
					<input class="w3-input w3-border w3-round" type="email" name="email" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Phone *
					<input class="w3-input w3-border w3-round" type="text" name="phone" value="" placeholder="" required>
				</div>

				<div class="w3-section" >					
					Course *
					<input class="w3-input w3-border w3-round" type="text" name="course" value="" placeholder="" required>
				</div>

				<hr class="w3-clear">

				<div class="w3-section" >
					<input name="act" type="hidden" value="add">
					<button type="submit" class="w3-button w3-black w3-text-white w3-round">Submit</button>
				</div>

		</form> 
         
      </div>

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

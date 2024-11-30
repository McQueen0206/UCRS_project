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

$act 			= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	
$id_announcement= (isset($_REQUEST['id_announcement'])) ? trim($_REQUEST['id_announcement']) : '';	

$announcement	= (isset($_POST['announcement'])) ? trim($_POST['announcement']) : '';
$title			= (isset($_POST['title'])) ? trim($_POST['title']) : '';

$announcement	=	mysqli_real_escape_string($con, $announcement);
$title			=	mysqli_real_escape_string($con, $title);

$error = "";
$success = "";

$sql_pre 	= "SELECT * FROM `president` WHERE `id_president` =  $id_president";
$rst_pre 	= mysqli_query($con, $sql_pre);
$dat_pre	= mysqli_fetch_array($rst_pre);
$id_club	= $dat_pre["id_club"];

if($act == "add")
{	
	$SQL_insert = " 		
		INSERT INTO `announcement`(`id_announcement`, `id_club`, `announcement`, `title`, `created_date`, `created_by`) 
				VALUES (NULL, '$id_club', '$announcement', '$title', NOW() , '$id_president')
	";	

	$result = mysqli_query($con, $SQL_insert);
	$success = "Successfully registered";
}


if($act == "edit")
{	
	$SQL_update = " 
	UPDATE `announcement` SET 
		`announcement` = '$announcement',
		`title` = '$title' 
	WHERE id_announcement = $id_announcement
	";
										
	$result = mysqli_query($con, $SQL_update);	
	$success = "Successfully Updated";	
	//print "<script>self.location='announcement.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `announcement` WHERE `id_announcement` =  '$id_announcement' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='announcement.php';</script>";
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

<!-- include summernote css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- include summernote js-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

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
if($success) { Notify("success", $success, "p-announcement.php"); }
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
	
	<a href="p-announcement.php" class="w3-bar-item w3-button w3-white">
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

<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-content w3-white w3-card w3-padding-16 w3-round" style="max-width:1000px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-padding">		
		
		<a onclick="document.getElementById('add01').style.display='block'; " class="w3-margin-bottom w3-right w3-button w3-black w3-round "><i class="fa fa-fw fa-lg fa-plus"></i> Add New</a>
		<div class="w3-large"><b>Announcement</b></div>

		<hr>
		
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
			<thead>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Announcement</th>
				<th>Created Date</th>
				<th class="w3-center" style="width:100px">Action</th>
			</tr>
			</thead>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `announcement` WHERE created_by = $id_president";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_announcement	= $data["id_announcement"];
			?>
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["title"];?></td>
				<td><?PHP echo $data["announcement"];?></td>
				<td><?PHP echo $data["created_date"];?></td>
				<td class="w3-center" >
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class="w3-hover-grey w3-padding-small w3-text-indigo"><i class="fas fa-edit"></i></a>
				<a href="#" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-hover-grey w3-padding-small w3-text-red"><i class="fas fa-trash-alt"></i></a>
				</td>
				
			</tr>	
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding-large">
		
			<form action="" method="post" class="w3-padding">
				<div class="w3-padding"></div>
				<b class="w3-large">Update Announcement</b>
				<hr>
		
				<div class="w3-section" >					
					Title *
					<input class="w3-input w3-border w3-round" type="text" name="title" value="<?PHP echo $data["title"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Announcement *
					<textarea rows="8" class="w3-input w3-border w3-round" name="announcement" id="makeMeSummernote" placeholder="" required><?PHP echo $data["announcement"]; ?></textarea>
				</div>
  
				<hr class="w3-clear">
				<input type="hidden" name="id_announcement" value="<?PHP echo $data["id_announcement"];?>" >
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
			
			<input type="hidden" name="id_announcement" value="<?PHP echo $data["id_announcement"];?>" >
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
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('add01').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
	  
      <div class="w3-container w3-padding">
		
		<form action="" method="post" class="w3-padding">
			<div class="w3-padding"></div>
			<b class="w3-large">Add Announcement</b>
			<hr>
			  
				<div class="w3-section" >					
					Title *
					<input class="w3-input w3-border w3-round" type="text" name="title" value="" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Announcement *
					<textarea rows="8" class="w3-input w3-border w3-round" name="announcement" id="makeMeSummernote2" placeholder="" required></textarea>
				</div>

				<hr class="w3-clear">

				<div class="w3-section" >
					<input name="act" type="hidden" value="add">
					<button type="submit" class="w3-button w3-black w3-text-white w3-round">Submit</button>
				</div>

		</form> 
         
      </div>

</div>

<!-- Simple Tool Bar -->
<script type="text/javascript">
	$('#makeMeSummernote,#makeMeSummernote2').summernote({
	  toolbar: [
		// [groupName, [list of button]]
		['style', ['bold', 'italic', 'underline', 'clear']],
		['font', ['strikethrough', 'superscript', 'subscript']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['height', ['height']]
	  ],
	  height:300,
	});
</script>

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

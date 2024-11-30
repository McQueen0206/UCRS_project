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
$act			= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$id_club		= (isset($_REQUEST['id_club'])) ? trim($_REQUEST['id_club']) : '';	

$club_name		= (isset($_POST['club_name'])) ? trim($_POST['club_name']) : '';
$description 	= (isset($_POST['description'])) ? trim($_POST['description']) : '';
$year_est 		= (isset($_POST['year_est'])) ? trim($_POST['year_est']) : '';

$club_name		=	mysqli_real_escape_string($con, $club_name);
$description	=	mysqli_real_escape_string($con, $description);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`club`
	SET	
		`club_name` = '$club_name',
		`description` = '$description',
		`year_est` = '$year_est'
	WHERE
		id_club = $id_club
	";
										
	$result = mysqli_query($con, $SQL_update);
	
	// -------- Photo -----------------
	if(isset($_FILES['logo'])){
	if(($_FILES["logo"]["error"] == 0) && (isset($_FILES['logo']))) {
		 
		  $file_name = $_FILES['logo']['name'];
		  $file_size = $_FILES['logo']['size'];
		  $file_tmp = $_FILES['logo']['tmp_name'];
		  $file_type = $_FILES['logo']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  $new_file	= rand() . "." . $file_ext;
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"upload/".$new_file);
			 
			// Crop the image to 300x300
			$targetFile = "upload/".$new_file;
			$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));						 
            cropImage($targetFile, $imageFileType);
			// -------------------------
			 
			$query = "UPDATE `club` SET `logo`='$new_file' WHERE `id_club` = $id_club";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}}
	// -------- End Photo -----------------
	
	$success = "Successfully Updated";
	
	//print "<script>self.location='club.php';</script>";
}

if($act == "del_logo")
{
	$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `logo` as logo_del FROM `club` WHERE `id_club`= '$id_club'"));
	unlink("upload/" .$dat['logo_del']);
	$rst_d = mysqli_query( $con, "UPDATE `club` SET `logo`='' WHERE `id_club` = '$id_club' " );
	print "<script>self.location='p-club.php';</script>";
}

$sql_pre 	= " SELECT * FROM `president` WHERE `id_president` =  $id_president";
$rst_pre 	= mysqli_query($con, $sql_pre);
$dat_pre	= mysqli_fetch_array($rst_pre);
$name		= $dat_pre["name"];
$id_club	= $dat_pre["id_club"];

$sql_stu 	= " SELECT * FROM `club` WHERE `id_club` =  $id_club";
$rst_stu 	= mysqli_query($con, $sql_stu);
$data		= mysqli_fetch_array($rst_stu);
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
if($success) { Notify("success", $success, "p-club.php"); }
?>	

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-ungu w3-card" style="z-index:3;width:250px;" id="mySidebar">
	<a href="p-main.php" class="w3-bar-item w3-large"><img src="images/logo.png" class="w3-padding" style="width:200px;"></a>
	<a href="javascript:void(0)" onclick="w3_close()" title="Close Sidemenu" 
	class="w3-bar-item w3-button w3-hide-large w3-large">Close <i class="fa fa-remove"></i></a>

	<a href="p-main.php" class="w3-bar-item w3-button">
	<i class="fa fa-fw fa-tachometer-alt w3-margin-right"></i> Dashboard</a>

	<a href="p-club.php" class="w3-bar-item w3-button w3-white">
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
  
	<form action="" method="post" enctype="multipart/form-data" >
	<div class="w3-padding-16 w3-padding w3-card w3-white">
		
		<div class="">
		<div class="w3-padding">
			<b class="w3-large">Update Club</b>
			<hr>
			 		  
				<div class="w3-section" >
					Logo (400px X 400px) *
					<?PHP if($data["logo"] =="") { ?>
					<div class="custom-file">
						<input type="file" class="w3-input w3-border w3-round" name="logo" id="logo" accept=".jpeg, .jpg,.png,.gif" required>
					</div>
					<p></p>
					<?PHP } ?>
										
					<?PHP if($data["logo"] <>"") { ?>
					<div class="w3-input w3-border w3-round">
					<a class="w3-tag w3-green w3-round" target="_BLANK" href="upload/<?PHP echo $data["logo"]; ?>"><small>View</small></a>

					<a class="w3-tag w3-red w3-round" href="?act=del_logo&id_club=<?PHP echo $data["id_club"];?>"><small>Remove</small></a>
					</div>
					<?PHP } else { ?><span class="w3-tag w3-round"> <small>None</small></span><?PHP } ?>
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
				
				<div class="w3-section" >					
					Club Name *
					<input class="w3-input w3-border w3-round" type="text" name="club_name" value="<?PHP echo $data["club_name"]; ?>" placeholder="" required>
				</div>
				
				<div class="w3-section" >					
					Description *
					<textarea class="w3-input w3-border w3-round" rows="6" name="description" id="makeMeSummernote" required><?PHP echo $data["description"]; ?></textarea>
				</div>
				
				<div class="w3-section" >					
					Year Established *
					<input class="w3-input w3-border w3-round" type="number" name="year_est" value="<?PHP echo $data["year_est"]; ?>" placeholder="" required>
				</div>
			
			<hr>

			<div class="w3-section" >
				<input name="id_club" type="hidden" value="<?PHP echo $id_club;?>">
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


<!-- Script -->
<script type="text/javascript">
	$('#makeMeSummernote,#makeMeSummernote2').summernote({
		height:200,
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

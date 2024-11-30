<?PHP
session_start();
include("database.php");
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
    <div class="w3-content w3-container " style="max-width:1000px">
		<div class="w3-padding w3-center w3-text-white">
			<h1><b>UCRS - UPTM Club Registration System</b><h1>
		</div>
    </div>
</div>
		
<div class="w3-biru w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container" style="max-width:1000px">
		<div class="w3-padding">
			
			<div class="w3-center w3-large"><b>CLUB</b></div>
			
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `club` LIMIT 6";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_club	= $data["id_club"];
				$logo	= $data["logo"];
				if(!$logo)  $logo = "noimage.jpg";	
			?>
			<div class="w3-col m4 w3-padding w3-center">
				<div class="w3-hover-light-grey w3-white w3-round-large w3-card w3-padding-16">

					<div class="w3-center"><img src="upload/<?PHP echo $logo; ?>" class="w3-round-large w3-image" alt="image" style="width:100%;max-width:200px"></div>
					
					<h4><b><?PHP echo $data["club_name"];?></b></h4>
					
					<a href="#" onclick="document.getElementById('idViewClub<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-small w3-blue">Detail</a>
				</div>
			</div>
			
<div id="idViewClub<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idViewClub<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding-large">
		
			<div class="w3-center"><img src="upload/<?PHP echo $logo; ?>" class="w3-round-large w3-image" alt="image" style="width:100%;max-width:200px"></div>
					
			<h4><b><?PHP echo $data["club_name"];?></b></h4>
			<hr>
			<?PHP echo $data["description"];?>

			<hr>				
			Year Established : <?PHP echo $data["year_est"];?>
			<hr>
			<div class="w3-center">
				<a href="login.php" class="w3-button w3-blue">Join</a>
				<a onclick="document.getElementById('idViewClub<?PHP echo $bil; ?>').style.display='none'" class="w3-button w3-grey">Close</a>											
			</div>			
		</div>
	</div>
</div>
			
			<?PHP } ?>
			
		</div>
		
    </div>
</div>

<div class="w3-ungux w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container" style="max-width:1000px">
		<div class="w3-padding">
			
			<div class="w3-center w3-large w3-text-white"><b>EVENT</b></div>			
			
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `event` LIMIT 6";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_event	= $data["id_event"];
				$participant= $data["participant"];
				
				$tot_join	= numRows($con, "SELECT * FROM `event_join` WHERE id_event = $id_event");
			?>
			<div class="w3-col m4 w3-padding w3-center">
				<div class="w3-hover-light-grey w3-white w3-round-large w3-card w3-padding-16">					
					
					<div class="w3-largex"><b><?PHP echo $data["event_name"];?></b></div>
					<hr>
					
					<a href="#" onclick="document.getElementById('idViewEvent<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-small w3-blue">Detail</a>					
				</div>
			</div>
			
<div id="idViewEvent<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idViewEvent<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding-large">
					
					<h4><b><?PHP echo $data["event_name"];?></b></h4>
					
					<?PHP echo $data["description"];?>

					<hr>				
					
					<div class="w3-row">
						<div class="w3-col s3">Location : </div>
						<div class="w3-col s9"><?PHP echo $data["location"];?></div>
					</div>
					<div class="w3-row">
						<div class="w3-col s3">Event Date : </div>
						<div class="w3-col s9"><?PHP echo $data["event_date"];?></div>
					</div>
					<div class="w3-row">
						<div class="w3-col s3">Participant : </div>
						<div class="w3-col s9"><?PHP echo $tot_join ." / " . $participant;?></div>
					</div>
					
					<hr>
					<div class="w3-center">
						<a href="login.php" class="w3-button w3-blue">Join</a>					
						<a onclick="document.getElementById('idViewEvent<?PHP echo $bil; ?>').style.display='none'" class="w3-button w3-grey">Close</a>					
					</div>			
		</div>
	</div>
</div>
			
			<?PHP } ?>
			
			
		</div>
		
    </div>
</div>
 

<div class="w3-padding-16"></div>

<?PHP include("footer.php");?>

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

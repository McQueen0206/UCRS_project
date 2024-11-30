<?PHP
session_start();
include("database.php");
?>
<?PHP
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>UCRS - UPTM Club Registration System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href='https://fonts.googleapis.com/css?family=RobotoDraft' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "RobotoDraft", "Roboto", sans-serif}
a:link {
  text-decoration: none;
}
.w3-bar-block .w3-bar-item {padding: 16px}
.w3-biru {background-color:#f6f9ff;}

table {
  font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
}
</style>
</head>
<body onload="print();">

<!-- Page content -->
<div class="w3-main">


<div class="w3-padding-16"></div>

<div class="w3-padding-16 w3-container w3-content w3-xlarge " style="max-width:1000px;">
	<b>EVENT REPORT</b>
</div>

<div class="w3-container">

	<!-- Page Container -->
	<div class="w3-container w3-content " style="max-width:1000px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white">		

		
		<div class="table-responsive">
		<table class="w3-table w3-table-all xtable-bordered"  width="100%" cellspacing="0">
			<thead>
			<tr>
				<th>#</th>
				<th>Club</th>
				<th>Event Name</th>
				<th>Location</th>
				<th>Event Date</th>
				<th class="w3-center">Participant</th>
			</tr>
			</thead>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `event`,`club` WHERE event.id_club = club.id_club";
			$result = mysqli_query($con, $SQL_list) ;
			if($result) {
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
				$id_event	= $data["id_event"];
				$participant= $data["participant"];
				$tot_join	= numRows($con, "SELECT * FROM `event_join` WHERE id_event = $id_event");
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["club_name"];?></td>
				<td><?PHP echo $data["event_name"];?></td>
				<td><?PHP echo $data["location"];?></td>
				<td><?PHP echo $data["event_date"];?></td>
				<td class="w3-center"><?PHP echo $tot_join ." / " . $participant;?></td>
			</tr>
			<?PHP } } ?>
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


<div class="w3-padding-16"><div>

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

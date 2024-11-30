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

<div  >

<div class="w3-padding-48"></div>
		
<div class="w3-container w3-padding-16" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:800px">
		<div class="w3-padding ">
			
			<h3 class=""><b>Association and Clubs</b></h3>
			<hr>
			
			<p><b>CLUBS AND SOCIETIES</b>. Apart from the existing clubs mentioned, students can also form new associations or clubs of their interests by submitting the following items along with the application form to the unit for approval.</p>

			<p>The items required are:</p>

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

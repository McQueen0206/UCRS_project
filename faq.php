<?PHP
session_start();
?>
<!DOCTYPE html>
<html>
<title>UCRS - UPTM Club Registration System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
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

a:link {
  text-decoration: none;
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
    <div class="w3-content w3-container w3-white w3-round-large w3-card" style="max-width:900px">
		<div class="w3-padding w3-padding-16">
			
			
			<div class="w3-center w3-xlarge"><b>Frequently Asked Questions</b></div>
			
			<div class="w3-padding"></div>
			
			<div onclick="myFunction('Faq1')" class="w3-border-bottom w3-padding-16 w3-padding w3-hover-light-grey w3-left-align">1.&nbsp; How do I register for a club using the system? <i class="w3-padding w3-right fa fa-chevron-down"></i></div>
			<div id="Faq1" class="w3-hide w3-container w3-light-grey w3-border">
				<p>To register for a club, log into the system, navigate to the "Club Listings" page, select the club you’re interested in, and click the "Join" button. Follow the prompts to complete your registration.</p>
			</div>

			<div onclick="myFunction('Faq2')" class="w3-border-bottom w3-padding-16 w3-padding w3-hover-light-grey w3-left-align">2.&nbsp; Can I join multiple clubs at the same time?  <i class="w3-padding w3-right fa fa-chevron-down"></i></div>
			<div id="Faq2" class="w3-hide w3-container  w3-light-grey w3-border">
				<p>Yes, you can join multiple clubs through the system. Each club may have specific requirements or approval processes, so ensure you meet their criteria before applying.</p>
			</div>
			
			<div onclick="myFunction('Faq3')" class="w3-border-bottom w3-padding-16 w3-padding w3-hover-light-grey w3-left-align">3.&nbsp; How do I update my profile information?  <i class="w3-padding w3-right fa fa-chevron-down"></i></div>
			<div id="Faq3" class="w3-hide w3-container  w3-light-grey w3-border">
				<p>Log into the system and go to the "Profile" section. From there, you can update your personal information, such as your contact details or interests.</p>
			</div>
			
			<div onclick="myFunction('Faq4')" class="w3-border-bottom w3-padding-16 w3-padding w3-hover-light-grey w3-left-align">4.&nbsp; What should I do if I forget my password?  <i class="w3-padding w3-right fa fa-chevron-down"></i></div>
			<div id="Faq4" class="w3-hide w3-container  w3-light-grey w3-border">
				<p>On the login page, click the "Forgot Password" link and follow the instructions to reset your password. An email with a reset link will be sent to your registered email address.</p>
			</div>
			
			<div onclick="myFunction('Faq5')" class="w3-border-bottom w3-padding-16 w3-padding w3-hover-light-grey w3-left-align">5.&nbsp; How can I view upcoming club events? <i class="w3-padding w3-right fa fa-chevron-down"></i></div>
			<div id="Faq5" class="w3-hide w3-container  w3-light-grey w3-border">
				<p>Navigate to the "Events" page within the system to view a list of upcoming events for all clubs you are registered with. You can also register for events directly from this page.</p>
			</div>

			<script>
			function myFunction(id) {
			  var x = document.getElementById(id);
			  if (x.className.indexOf("w3-show") == -1) {
				x.className += " w3-show";
				x.previousElementSibling.className = 
				x.previousElementSibling.className.replace("w3-black", "w3-red");
			  } else { 
				x.className = x.className.replace(" w3-show", "");
				x.previousElementSibling.className = 
				x.previousElementSibling.className.replace("w3-red", "w3-black");
			  }
			}
			</script>
			
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

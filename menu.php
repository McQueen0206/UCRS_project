<style>
.w3-biru {background-color:#f6f9ff;}
.w3-ungu {background-color:#979df9;}
</style>
<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-ungu w3-paddingx" id="myNavbar">
    &nbsp;<a href="index.php"><img src="images/logo.png" height="55"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">			
		<a href="index.php" class="w3-bar-item w3-button "><b>HOME</b></a>
		<a href="about.php" class="w3-bar-item1 w3-button "><b>ABOUT</b></a>
		<a href="faq.php" class="w3-bar-item1 w3-button "><b>F.A.Q.</b></a>
		<a href="login.php" class="w3-bar-item1 w3-button "><b>LOGIN</b></a>
		<a href="admin.php" class="w3-bar-item1 w3-button "><b> ADMIN</b></a>
    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>



<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-indigo w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
  
  <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">HOME</a>
  <a href="about.php" onclick="w3_close()" class="w3-bar-item w3-button">ABOUT</a>
  <a href="admin.php" onclick="w3_close()" class="w3-bar-item w3-button">ADMIN</a>
</nav>

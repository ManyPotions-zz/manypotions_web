<?php 
include 'libraries/php-ref/ref.php'; //Pour faire des beau VARDUMP
require ('steamauth/steamauth.php');
# You would uncomment the line beneath to make it refresh the data every time the page is loaded
// unset($_SESSION['steam_uptodate']);
?>
<!DOCTYPE html>
<html>
<title>manyPotions</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/main.css">
<link rel="stylesheet" href="style/mpindex.css">
<body>
<!-- backgroud effect -->
<div class="backdrop">
    <div class="header"></div>
    <div class="magic"></div>
  </div>
<!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-red w3-card-2 w3-left-align w3-large">
    <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
      <a class="w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="index.php" class="w3-padding-large w3-white">Home</a></li>
    <li class="w3-hide-small"><a href="serverconan.php" class="w3-padding-large w3-hover-white">Conan Exile</a></li>
    <li class="w3-hide-small"><a href="serverrust.php" class="w3-padding-large w3-hover-white">Rust</a></li>
    <!--<li class="w3-hide-small"><a href="#" class="w3-padding-large w3-hover-white">Link 3</a></li>-->
    <li class="w3-hide-small mp-login-btn"><a href="login.php" class="w3-padding-large w3-hover-white">
	<?php
	if(!isset($_SESSION['steamid'])) {
    echo "Login"; 
	}  else {
    include ('steamauth/userInfo.php');
    echo "<img src='".$steamprofile['avatar']."'>  " . $steamprofile['personaname'] . "";
	} 
	?>
	</a></li>
  </ul>
  


  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-hide w3-hide-large w3-hide-medium">
    <ul class="w3-navbar w3-left-align w3-large w3-black">
      <li><a class="w3-padding-large" href="serverconan.php">Conan Exile</a></li>
      <li><a class="w3-padding-large" href="serverrust.php">Rust</a></li>
      <li><a class="w3-padding-large" href="#">Login</a></li>
      <!--<li><a class="w3-padding-large" href="#">Link 4</a></li>-->
    </ul>
  </div>
</div>

<!-- Header -->
<header>
	<div class="w3-container mp-header w3-center w3-padding-128">
	  <!--<h1 class="w3-margin w3-jumbo mp-titre">manyPotions</h1>-->
	  <p class="w3-xlarge"></p>
	</div>
	<div>
		<h1 class="mp-titre"><img src="../images/mplogos.png"></h1>
	</div>
  <!--<button class="w3-btn w3-padding-16 w3-large w3-margin-top">Get Started</button> -->
</header>

<!-- START First Grid -->

<div class="w3-row-padding  w3-padding-64 w3-container mp-container">
  <div class="mp-content">
  
	<div class='mp-".$game."'>
		<div class='mp-images-holder'>
			</div>

		<h1>Titre</h1>	
		<div class='mp-text-description'>
		TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 TEXT2 
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		TEXT2 <br>
		</div>
	</div>
	<br>

  </div>
</div>



<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge"></h1>
</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center mp-footer">  
  <div class="w3-xlarge w3-padding-32">
   <a href="#" class="w3-hover-text-indigo"><i class="fa fa-facebook-official"></i></a>
   <a href="#" class="w3-hover-text-red"><i class="fa fa-pinterest-p"></i></a>
   <a href="#" class="w3-hover-text-light-blue"><i class="fa fa-twitter"></i></a>
   <a href="#" class="w3-hover-text-grey"><i class="fa fa-flickr"></i></a>
   <a href="#" class="w3-hover-text-indigo"><i class="fa fa-linkedin"></i></a>
 </div>
 <p>manypotions &copy; 2010-<?php echo date("Y");?></p>
</footer>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}


</script>

</body>
</html>

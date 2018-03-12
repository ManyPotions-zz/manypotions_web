<?php
include 'libraries/php-ref/ref.php'; // Pour faire des beau VARDUMP
require ('steamauth/steamauth.php');
// You would uncomment the line beneath to make it refresh the data every time the page is loaded
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
			<li class="w3-hide-medium w3-hide-large w3-opennav w3-right"><a
				class="w3-padding-large w3-hover-white w3-large w3-red"
				href="javascript:void(0);" onclick="myFunction()"
				title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a></li>
			<li><a href="index.php" class="w3-padding-large w3-white">Home</a></li>
			<li class="w3-hide-small"><a href="serverconan.php"
				class="w3-padding-large w3-hover-white">Conan Exile</a></li>
			<li class="w3-hide-small"><a href="serverrust.php"
				class="w3-padding-large w3-hover-white">Rust</a></li>
			<!--<li class="w3-hide-small"><a href="#" class="w3-padding-large w3-hover-white">Link 3</a></li>-->
			<li class="w3-hide-small mp-login-btn"><a href="login.php"
				class="w3-padding-large w3-hover-white">
	<?php
	if (! isset ( $_SESSION ['steamid'] )) {
		echo "Login";
	} else {
		include ('steamauth/userInfo.php');
		echo "<img src='" . $steamprofile ['avatar'] . "'>  " . $steamprofile ['personaname'] . "";
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
			<h1 class="mp-titre">
				<img src="../images/mplogos.png">
			</h1>
		</div>
		<!--<button class="w3-btn w3-padding-16 w3-large w3-margin-top">Get Started</button> -->
	</header>

	<!-- START First Grid -->

	<div class="w3-row-padding  w3-padding-64 w3-container mp-container">
		<div class="mp-content">

			<div class='mp-rule' itemscope itemtype='https://schema.org/GameServer'>
				<div class='mp-images-holder'> Nom du Serveur: //   Joueur en ligne: <span itemprop="playersOnline"> </span>
				</div>


				<span itemscope itemtype='http://schema.org/Thing'>
					<h1 itemprop="name">[QC] ManyPotions.com - [ 1X | LOOT+ | WEB ]</h1>
					<div class='mp-text-description' itemprop="description">

						Bienvenue sur le Serveur Vanilla de Manypotions.<br>
						Wipe premier jeudi du mois.<br> 
						<br> 
						Nous vous demandons d'agir d'une maniere mature et de respecter les autres joueurs.<br>
						<br> 
						-Regles<br>
						Aucune utilisation de cheats / hack<br> 
						Ne pas pretendre etre un membre du personnel.<br>
						Aucun Spam et/ou harcelement.<br> 
						Aucun Grief<br>
						Il est permis aux joueurs de construire des murs autour de leur base. Cependant, l'érection de murs destinés a obstruer l'acces aux ressources ou a bloquer une zone sont proscrits et seront détruits.<br>
						<br> 
						Adresse IP: 74.57.233.14 Port: 28026<br>
						DNS: <span itemprop="url"> server.manypotions.com:28026 </span><br>
						<br>									
					</div>
				</span>
				<span>
								 
				 <?php
				$servername = "localhost";
				$username = "manypotions_rustuser";
				$password = "QQ2t4ng0d0wn";
				$dbname = "manypotions_rustdb";

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					 die("Connection failed: " . $conn->connect_error);
				}
				?>


				
				<div class="articlestats">
				<div class='mp-playeronline-warp'>

				<?php
				// LIST ONLINE


				$sql = "SELECT player_id, player_name, player_state, player_online_time, player_last_login FROM player_stats WHERE player_state = 1 ORDER BY player_online_time DESC";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
				echo "<h3>Online player</h3>";	
				echo "<table  class='mp-playertable'>";
				  echo "<tr>";
					echo "<th>Name</th>";
					echo "<th>Kill</th>";
					echo "<th>Time played</th>";
					echo "<th>Last login</th>";
				  echo "</tr>";

					while($row = $result->fetch_assoc()) {	
					$current_playerstate = $row['player_state'];
					$current_steamid = $row['player_id'];
					$current_lastlogin = $row['player_last_login'];				
					$current_onlinename = $row["player_name"];
					$current_onlinetemp = $row["player_online_time"];
					$current_onlinehours = floor($current_onlinetemp / 3600);
					$current_onlinemins = floor(($current_onlinetemp - ($current_onlinehours*3600)) / 60);
					$current_onlinemins = sprintf("%02d", $current_onlinemins);
					if($current_onlinename == null){
					$current_onlinename = 'ManyPotions Name.';
					}; 
					$current_totalplayerkill = 0;
					//DEBUG
					//r($current_playerstate);
					//END DEBUG
					

						$sql3 = "SELECT killer_id FROM player_kill WHERE killer_id = $current_steamid";
						$result3 = $conn->query($sql3);
						if ($result3->num_rows > 0) {
							// output data of each row
							while($row3 = $result3->fetch_assoc()) {					
							$current_totalplayerkill++ ;				
							};
						};
					
					echo "<tr  class='clickable-row' data-href='serverstatsrust.php?id=".$current_steamid."'>";
					echo "<td>".$current_onlinename."</td>";
					echo "<td>".$current_totalplayerkill."</td>";
					echo "<td>".$current_onlinehours.":".$current_onlinemins."</td>";
					echo "<td>".$current_lastlogin."</td>";
					echo "</tr>";
					
					};
					echo "</table>";
					echo "<br>";
				//end LIST ONLINE
				} else {
					echo "<div class='articleofflinenow'>";
					echo "<h3>Aucun joueur n'est en linge actuellement.</h3>";
					echo "</div>";
					echo "<br>";
				};

				// Creation list for offline
				
				$sql = "SELECT player_id, player_name, player_state, player_online_time, player_last_login FROM player_stats WHERE player_state = 0 ORDER BY player_online_time DESC";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
				echo "<h3>Offline player</h3>";	
				echo "<table  class='mp-playertable'>";
				  echo "<tr>";
					echo "<th>Name</th>";
					echo "<th>Kill</th>";
					echo "<th>Time played</th>";
					echo "<th>Last login</th>";
				  echo "</tr>";

					while($row = $result->fetch_assoc()) {	
					$current_playerstate = $row['player_state'];
					$current_steamid = $row['player_id'];
					$current_lastlogin = $row['player_last_login'];				
					$current_onlinename = $row["player_name"];
					$current_onlinetemp = $row["player_online_time"];
					$current_onlinehours = floor($current_onlinetemp / 3600);
					$current_onlinemins = floor(($current_onlinetemp - ($current_onlinehours*3600)) / 60);
					$current_onlinemins = sprintf("%02d", $current_onlinemins);
					if($current_onlinename == null){
					$current_onlinename = 'ManyPotions Name.';
					}; 
					$current_totalplayerkill = 0;
					//DEBUG
					//r($current_playerstate);
					//END DEBUG
					

						$sql3 = "SELECT killer_id FROM player_kill WHERE killer_id = $current_steamid";
						$result3 = $conn->query($sql3);
						if ($result3->num_rows > 0) {
							// output data of each row
							while($row3 = $result3->fetch_assoc()) {					
							$current_totalplayerkill++ ;				
							};
						};
					
					echo "<tr  class='clickable-row' data-href='serverstatsrust.php?id=".$current_steamid."'>";
					echo "<td>".$current_onlinename."</td>";
					echo "<td>".$current_totalplayerkill."</td>";
					echo "<td>".$current_onlinehours.":".$current_onlinemins."</td>";
					echo "<td>".$current_lastlogin."</td>";
					echo "</tr>";
					
					};
					echo "</table>";
					echo "<br>";
				//end LIST ONLINE
				} else {
					echo "<div class='articleofflinenow'>";
					echo "<h3>Aucun joueur n'est en linge actuellement.</h3>";
					echo "</div>";
					echo "<br>";
				};
				//Cration Kill Feed
				
				$sql = "SELECT killer_id, victim_id, bodypart, weapon, distance, time FROM player_kill ORDER BY time DESC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
					
					
				echo "<table class='mp-killtable'>";	
				echo "<tr><th colspan='5'><h3>Kill Feed</h3></th></tr>";
					
					
					while($row = $result->fetch_assoc()) {
						
						
				$killer_id = $row["killer_id"];
				$victim_id = $row["victim_id"];
				$weapon = $row["weapon"];
				$distance = $row["distance"];
				$date = $row["time"];
				

				$sqlkiller = "SELECT player_id, player_name, player_online_time, player_state FROM player_stats WHERE player_id = '$killer_id'";
				$resultkiller = $conn->query($sqlkiller);
				while($rowkiller = $resultkiller->fetch_assoc()) {
					$killerpersonaname = $rowkiller["player_name"];
					$killersteamid = $rowkiller["player_id"];
				 };
				 
				$sqlvictim = "SELECT player_id, player_name, player_online_time, player_state FROM player_stats WHERE player_id = '$victim_id'";
				$resultvictim = $conn->query($sqlvictim);
				while($rowvictim = $resultvictim->fetch_assoc()) {
					$victimidpersonaname = $rowvictim["player_name"];
					$victimesteamid = $rowvictim["player_id"];		
				 };

						


						
				
				echo "<tr><td  class='mp-clic-td' ><a href='serverstatsrust.php?id=".$killersteamid."' > ".$killerpersonaname." </a></td><td>".$weapon."</td><td>".$distance." m</td><td class='mp-clic-td' ><a href='serverstatsrust.php?id=".$victimesteamid."' > ".$victimidpersonaname." </a></td><td>".$date."</td></tr>";
						
						
						
					};
					
				echo "</table>";
				} else {
				echo "0 results";
				};
				$conn->close();



			
				
				
				
				
				?> 
				</div>
				</div>
				  
				</span>
			</div>
		</div>		
	</div>



	<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
		<h1 class="w3-margin w3-xlarge"></h1>
	</div>

	<!-- Footer -->
	<footer class="w3-container w3-padding-64 w3-center mp-footer">

		<div itemscope="" itemtype="http://schema.org/Organization">
			<meta itemprop="description" content=" We're passionate about creating the tools and communities for the 2 or 3 gamers that use our sites every day.">
			<span itemprop="name" style="display: block;"><strong>manyPotions</strong></span>
			<div itemprop="address" itemscope=""
				itemtype="http://schema.org/PostalAddress">

				<span itemprop="addressRegion">Quebec</span> <span
					itemprop="addressCountry">Canada</span>
			</div>
		</div>
		<p>manypotions &copy; 2010-<?php echo date("Y");?></p>
	</footer>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
// Make row clickable

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});


</script>

</body>
</html>

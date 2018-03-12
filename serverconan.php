<?php
include 'libraries/php-ref/ref.php'; // Pour faire des beau VARDUMP
require ('steamauth/steamauth.php');
// You would uncomment the line beneath to make it refresh the data every time the page is loaded
// unset($_SESSION['steam_uptodate']);
?>
<?php

require __DIR__ . '/xPaw/SourceQuery/bootstrap.php';

use xPaw\SourceQuery\SourceQuery;

// For the sake of this example
// Header( 'Content-Type: text/plain' );
// Header( 'X-Content-Type-Options: nosniff' );

define ( 'SQ_SERVER_ADDR', '74.57.233.14' );
define ( 'SQ_SERVER_PORT', 27015 );
define ( 'SQ_QUERY_PORT', 7777 );
define ( 'SQ_PASSWORD', 'caca1337' );
define ( 'SQ_TIMEOUT', 5 );
define ( 'SQ_ENGINE', SourceQuery::SOURCE );

$Timer = MicroTime ( true );

$Query = new SourceQuery ();

$Info = Array ();
$Rules = Array ();
$Players = Array ();

try {
	$Query->Connect ( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
	
	// $Query->SetUseOldGetChallengeMethod( true ); // Use this when players/rules retrieval fails on games like Starbound
	
	$Info = $Query->GetInfo ();
	$Players = $Query->GetPlayers ();
	$Rules = $Query->GetRules ();
} catch ( Exception $e ) {
	$Exception = $e;
} finally
	{
	$Query->Disconnect ();
}

// $Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );

// r($Info);
$ModDesc = $Info ['ModDesc'];
$HostName = $Info ['HostName'];
$MaxPlayers = $Info ['MaxPlayers'];
$CurrentPlayer = $Info ['Players'];
$Map = $Info ['Map'];

// r($Rules);
// r($Players);

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

			<div class='mp-440900'>
				<div class='mp-images-holder'>
		Nom du Serveur: <?php echo $HostName ;?>//   Joueur en ligne: <?php echo $CurrentPlayer ;?>/<?php echo $MaxPlayers ;?>
		</div>



				<h1><?php echo $HostName ;?></h1>




				<div class='mp-text-description'>

					Bienvenue sur le Serveur Vanilla de Manypotions.<br> Wipe premier
					jeudi du mois.<br> <br> Nous vous demandons d'agir d'une maniere
					mature et de respecter les autres joueurs.<br> <br> -Regles<br>
					Aucune utilisation de cheats / hack<br> Ne pas pretendre etre un
					membre du personnel.<br> Aucun Spam et/ou harcelement.<br> Aucun
					Grief<br> Il est permis aux joueurs de construire des murs autour
					de leur base. Cependant, l'érection de murs destinés a obstruer
					l'acces aux ressources ou a bloquer une zone sont proscrits et
					seront détruits.<br> <br> Adresse IP: 74.57.233.14 Port: 27015<br>DNS:
					server.manypotions.com:27015<br> <br>
					<p class="w3-text-grey">
	  Mod: <?php echo $ModDesc ;?><br>
	  Map: <?php echo $Map ;?><br>
	  Joueur en ligne: <?php echo $CurrentPlayer ;?>/<?php echo $MaxPlayers ;?>	<br>  
	  Nom du Serveur: <?php echo $HostName ;?>	<br>
					</p>
					<p class="w3-text-grey">
					
					
					<table class="mp-playertable">
						<tr>
							<th>#</th>
							<th>Nom</th>
							<th>Temps de jeu</th>
						</tr>
	
	<?php
	$p = 1;
	foreach ( $Players as $Players ) :
		$pn = $Players ['Name'];
		$pt = $Players ['TimeF'];
		echo '<tr>';
		echo "<td>" . $p . "</td>";
		echo "<td>" . $pn . "</td>";
		echo "<td>" . $pt . "</td>";
		echo '</tr>';
		$p ++;
	endforeach
	;
	?>
	 
	</table>
					</p>



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

		<div itemscope="" itemtype="http://schema.org/Organization">
			<meta itemprop="description"
				content="
We're passionate about creating the tools and communities for the 2 or 3 gamers that use our sites every day.

">
			<span itemprop="name" style="display: block;"><strong>manyPotions</strong></span>
			<div itemprop="address" itemscope=""
				itemtype="http://schema.org/PostalAddress">

				<span itemprop="addressRegion">Quebec</span> <span
					itemprop="addressCountry">Canada</span>
			</div>
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

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
<?php
$gamelist = array (
		"rust" => "252490",
		"7 Days to Die" => "251570",
		"conan" => "440900" 
);
foreach ( $gamelist as $gamelist ) {
	// r($gamelist);
	
	date_default_timezone_set ( 'EST' );
	$feed = implode ( file ( "http://steamcommunity.com/games/$gamelist/rss/rss.xml" ) );
	$xml = simplexml_load_string ( $feed );
	$json = json_encode ( $xml );
	$array = json_decode ( $json, TRUE );
	
	// r($array);
	$newsarray = ($array ["channel"] ['item']);
	$gamename = ($array ["channel"] ["image"] ['title']);
	// r($gamename);
	
	foreach ( $newsarray as $newsarray ) {
		$game = $gamelist;
		$rsstitle = ($newsarray ['title']);
		$rssdescription = ($newsarray ['description']);
		// remplacer le href="https://steamcommunity.com/linkfilter/?url= par rien, affin d'eviter de passer par un steam approval.
		$filtered_text = str_replace ( 'https://steamcommunity.com/linkfilter/?url=', '', $rssdescription );
		// r($filtered_text);
		$rsspubDatefull = ($newsarray ['pubDate']);
		$rssauthor = ($newsarray ["author"]);
		// r($array );
		// r($game );
		// r($rssdescription);
		// r($rsspubDate);
		// r($rssauthor);
		$rsspubday = strstr ( $rsspubDatefull, ' ' );
		// r($rsspubday);
		$rsspubday = substr ( $rsspubday, 0, strrpos ( $rsspubday, ' ' ) );
		// r($rsspubday);
		$rsspubtime = substr ( $rsspubday, - 8, strrpos ( $rsspubday, ' ' ) );
		$rsspubtime = substr ( $rsspubtime, 0, strrpos ( $rsspubtime, ':' ) );
		// r($rsspubtime);
		$rsspubDate = substr ( $rsspubday, 0, strrpos ( $rsspubday, ' ' ) );
		// r($rsspubDate);
		$currentrss = array (
				"gamename" => $gamename,
				"game" => $game,
				"rsstitle" => $rsstitle,
				"rssdescription" => $filtered_text,
				"rsspubDatefull" => $rsspubDatefull,
				"rssauthor" => $rssauthor,
				"rsspubDate" => $rsspubDate 
		);
		// r($currentrss);
		$rssupdated [] = $currentrss;
	}
	;
}
;

// r($rssupdated);
function sortFunction($a, $b) {
	return strtotime ( $b ["rsspubDatefull"] ) - strtotime ( $a ["rsspubDatefull"] );
}
usort ( $rssupdated, "sortFunction" );
// r($rssupdated);

?> 
<div class="w3-row-padding  w3-padding-64 w3-container mp-container">
		<div class="mp-content">
  
  <?php
		foreach ( $rssupdated as $rssupdated ) {
			// r($rssupdated);
			
			$game = ($rssupdated ['game']);
			$rsstitle = ($rssupdated ['rsstitle']);
			$rssdescription = ($rssupdated ['rssdescription']);
			$rsspubDatefull = ($rssupdated ['rsspubDatefull']);
			$rssauthor = ($rssupdated ['rssauthor']);
			$rsspubDate = ($rssupdated ['rsspubDate']);
			$gamename = ($rssupdated ['gamename']);
			
			echo "<div class='mp-" . $game . "' itemscope itemtype='https://schema.org/Article'>";
			
			echo "<div class='mp-images-holder'>";
			echo "" . $rsstitle . " " . $game . " <span itemprop='about'>" . $gamename . "</span>";
			echo "</div>";
			
			echo "<h5 class='mp-author'>";
			echo "<i class='fa fa-calendar'></i> <span itemprop='datePublished'>" . $rsspubDate . "</span>   <i class='fa fa-user'></i> <span itemprop='author'>" . $rssauthor . "</span>";
			echo "</h5>";
			
			echo "<span itemprop='articleBody'>";
			echo "<h1>" . $rsstitle . "</h1>";
			
			echo "<div class='mp-text-description'>";
			echo "" . $rssdescription . "";
			echo "</div>";
			echo "</span>";
			
			echo "</div>";
			echo "<br>";
		}
		;
		
		?>
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
// fade effect


</script>

</body>
</html>

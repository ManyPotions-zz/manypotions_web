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
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>



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
<!---->
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


<?php
$steamid = htmlspecialchars($_GET["id"]);

 $api_key = "AC382DA532113E910BD86FEC3CF2DC31";
//---------------------------- Steam DATA ----------------------------										
	$apiUrlSteam = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$steamid";
	$apiSteamData = json_decode(file_get_contents($apiUrlSteam), true);
	$personaname = ($apiSteamData['response']['players']['0']['personaname']);
	$profileurl = ($apiSteamData['response']['players']['0']['profileurl']);
	$avatarfull = ($apiSteamData['response']['players']['0']['avatarfull']);
	$realname =  ($apiSteamData['response']['players']['0']['realname']);
	if($realname == null){
	$realname = ' ';
	} 
	//r($personaname); // Debug seulement 
	//r($realname); // Debug seulement 
	//r($steamid); // Debug seulement 
//---------------------------- rust apps data ----------------------------
	$rustdata = array();
	$apiUrlCs = "http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=252490&key=$api_key&steamid=$steamid";
	$apirustData = json_decode(file_get_contents($apiUrlCs), true);
	$rustdata = ($apirustData['playerstats']['stats']);
	//r($rustdata); // Debug seulement 
	

//---------------------------- Getting Resource gatther from DB ----------------------------
$totalWood = 0;
$totalStones = 0;
$totalMetal = 0;
$totalSulfur = 0;
$totalQM = 0;
$totalCloth = 0;
$totalAnimalFat = 0;
$totalBearMeat = 0;
$totalPork = 0;
$totalChickenBreast = 0;
$totalHumanMeat = 0;
$totalWolfMeat = 0;
$totalBoneFragments = 0;
$totalLeather = 0;
$totalMushroom = 0;
$totalCorn = 0;
$totalPumpkin = 0;

$resourceslist = Array(
    '0'	=> 'Wood',
    '1'	=> 'Stones',
    '2'	=> 'Metal Ore',
	'3'	=> 'Sulfur Ore',
	'4'	=> 'Cloth',
	'5'	=> 'Animal Fat',
	'6'	=> 'Bear Meat',
	'7'	=> 'Pork',
	'8'	=> 'Raw Chicken Breast',
	'9'	=> 'Raw Human Meat',
	'10'=> 'Raw Wolf Meat',
	'11'=> 'Bone Fragments',
	'12'=> 'Leather',
	'13'=> 'Mushroom',
	'14'=> 'Corn',
	'15'=> 'High Quality Metal Ore',
	'16'=> 'Pumpkin'

	
);
foreach($resourceslist as $resourceslist){ 
	$sql = "SELECT id, player_id, resource, amount, date FROM player_resource_gather WHERE player_id = $steamid AND resource = '$resourceslist'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {					
		$resourcename = $row["resource"];	
		$count = $row["amount"];

		if ($resourcename == 'Wood') {
			$totalWood = $totalWood + $count;
			};
		if ($resourcename == 'Stones') {
			$totalStones = $totalStones + $count;
			};			
		if ($resourcename == 'Metal Ore') {
			$totalMetal = $totalMetal + $count;
			};		
		if ($resourcename == 'Sulfur Ore') {
			$totalSulfur = $totalSulfur + $count;
			};		
		if ($resourcename == 'High Quality Metal Ore') {
			$totalQM = $totalQM + $count;
			};		
		if ($resourcename == 'Cloth') {
			$totalCloth = $totalCloth + $count;
			};
		if ($resourcename == 'Animal Fat') {
			$totalAnimalFat = $totalAnimalFat + $count;
			};
		if ($resourcename == 'Bear Meat') {
			$totalBearMeat = $totalBearMeat + $count;
			};
		if ($resourcename == 'Pork') {
			$totalPork = $totalPork + $count;
			};
		if ($resourcename == 'Raw Chicken Breast') {
			$totalChickenBreast = $totalChickenBreast + $count;
			};
		if ($resourcename == 'Bone Fragments') {
			$totalBoneFragments = $totalBoneFragments + $count;
			};
		if ($resourcename == 'Mushroom') {
			$totalMushroom = $totalMushroom + $count;
			};
		if ($resourcename == 'Raw Wolf Meat') {
			$totalWolfMeat = $totalWolfMeat + $count;
			};
		if ($resourcename == 'Leather') {
			$totalLeather = $totalLeather + $count;
			};	
		if ($resourcename == 'Raw Human Meat') {
			$totalHumanMeat = $totalHumanMeat + $count;
			};		
		if ($resourcename == 'Corn') {
			$totalCorn = $totalCorn + $count;
			};	
		if ($resourcename == 'Pumpkin') {
			$totalPumpkin = $totalPumpkin + $count;
			};		
			
		};
	};
};
/*
r($totalWood);
r($totalStones);
r($totalMetal);
r($totalSulfur);
r($totalQM);
r($totalCloth);
r($totalAnimalFat);
r($totalBearMeat);
r($totalPork);
r($totalChickenBreast);
r($totalHumanMeat);
r($totalWolfMeat);
r($totalBoneFragments);
r($totalLeather);
r($totalMushroom);
r($totalCorn);
r($totalPumpkin);
*/
//---------------------------- Getting Bulding destroy from DB ----------------------------
$buldingdes_Metal = 0;
$buldingdes_Stone = 0;
$buldingdes_Wood = 0;

$buildinggradelist = Array(
    '0'	=> 'METAL (750)',
    '1'	=> 'STONE (500)',
    '2'	=> 'WOOD (250)'
);


foreach($buildinggradelist as $buildinggradelist){ 
	$sql = "SELECT id, player_id, building, building_grade, weapon FROM player_destroy_building WHERE player_id = $steamid AND building_grade = '$buildinggradelist'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {					
		$resourcename = $row["building_grade"];	
		

		if ($resourcename == 'METAL (750)') {
			$buldingdes_Metal++ ;
			};
		if ($resourcename == 'STONE (500)') {
			$buldingdes_Stone++ ;
			};			
		if ($resourcename == 'WOOD (250)') {
			$buldingdes_Wood++ ;
			};		
		
		};
	};	
};		

/*	
r($buldingdes_Metal);
r($buldingdes_Stone);
r($buldingdes_Wood);
*/
//---------------------------- Getting Animal Kill from DB ----------------------------		
$animalkill_Stag = 0;
$animalkill_Horse = 0;
$animalkill_Bear = 0;
$animalkill_Boar = 0;
$animalkill_Chicken = 0;

$animallist = Array(
    '0'	=> 'STAG',
    '1'	=> 'HORSE',
	'2'	=> 'BEAR',
	'3'	=> 'BOAR',
    '4'	=> 'CHICKEN'
);

foreach($animallist as $animallist){ 
	$sql = "SELECT id, player_id, animal, distance, weapon FROM player_kill_animal WHERE player_id = $steamid AND animal = '$animallist'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {					
		$resourcename = $row["animal"];	

		if ($resourcename == 'STAG') {
			$animalkill_Stag++ ;
			};
		if ($resourcename == 'HORSE') {
			$animalkill_Horse++ ;
			};			
		if ($resourcename == 'BEAR') {
			$animalkill_Bear++ ;
			};		
		if ($resourcename == 'BOAR') {
			$animalkill_Boar++ ;
			};		
		if ($resourcename == 'CHICKEN') {
			$animalkill_Chicken++ ;
			};				
		};
	};	
};		

/*	
r($animalkill_Stag);
r($animalkill_Horse);
r($animalkill_Bear);		
r($animalkill_Boar);			
r($animalkill_Chicken);		
*/	
//---------------------------- Getting Time played from DB ----------------------------			
		
$sql = "SELECT player_id, player_name, player_state, player_online_time, player_last_login FROM player_stats WHERE player_id = $steamid ";

$result = $conn->query($sql);
if ($result->num_rows > 0) {

	while($row = $result->fetch_assoc()) {	
	$current_playerstate = $row['player_state'];
	$current_lastlogin = $row['player_last_login'];				
	$current_onlinetemp = $row["player_online_time"];
	$current_onlinehours = floor($current_onlinetemp / 3600);
	$current_onlinemins = floor(($current_onlinetemp - ($current_onlinehours*3600)) / 60);
	$current_onlinemins = sprintf("%02d", $current_onlinemins);
	}; 	
}; 		
		
//---------------------------- Getting Personal Max player_kill_animal from DB ----------------------------				

$killanimal_dis = '-';
$killanimal_wep = '-';
$killanimal_ani = '-';	
	

	$sql8 = "SELECT player_id, animal, weapon, distance FROM player_kill_animal WHERE player_id = $steamid ORDER BY distance ASC " ;
	$result8 = $conn->query($sql8);
	if ($result8->num_rows > 0) {
		// output data of each row
		while($row8 = $result8->fetch_assoc()) {					
		$killanimal_ani = $row8["animal"];
		$killanimal_dis = $row8["distance"];
		$killanimal_wep = $row8["weapon"];
		};
	};
// addint a 'm' for metter at distence
if (is_numeric($killanimal_dis)){
$killanimal_dis = $killanimal_dis . 'm';		
};		
//---------------------------- Getting Personal Max player_kill_Player from DB ----------------------------				

$killplayer_dis = '-';
$killplayer_wep = '-';
$killplayer_vic_id = '-';	
$killplayer_vic = '-';		

$sql8 = "SELECT killer_id, victim_id, weapon, distance FROM player_kill WHERE killer_id = $steamid ORDER BY distance ASC " ;
$result8 = $conn->query($sql8);
if ($result8->num_rows > 0) {
	// output data of each row
	while($row8 = $result8->fetch_assoc()) {					
	$killplayer_vic_id = $row8["victim_id"];
	$killplayer_dis = $row8["distance"];
	$killplayer_wep = $row8["weapon"];
	};
};
	//getting name for the victime ID
	$sql = "SELECT player_id, player_name, player_state, player_online_time, player_last_login FROM player_stats WHERE player_id = $killplayer_vic_id ";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {	
		$killplayer_vic = $row["player_name"];
		};
	};		
	
// Rmemoving word (BLEED TO DEATH) from the weapon name
$killplayer_wep = str_replace("(BLEED TO DEATH)", "", $killplayer_wep);		
// addint a 'm' for metter at distence
if (is_numeric($killplayer_dis)){
$killplayer_dis = $killplayer_dis . 'm';		
};
//---------------------------- Getting Personal player_bullets_fired from DB ----------------------------		
$ammo_buckshot = 0;
$ammo_slug = 0;
$ammo_556 = 0;
$ammo_beancan = 0;
$ammo_f1 = 0;
$ammo_556e = 0;
$ammo_hs = 0;
$ammo_arrowhv = 0;
$ammo_556hv = 0;
$ammo_pistolhv = 0;
$ammo_556i = 0;
$ammo_pistoli = 0;
$ammo_rocketi = 0;
$ammo_pistol = 0;
$ammo_rocket = 0;
$ammo_satchel = 0;
$ammo_rocketwip = 0;
$ammo_survey = 0;
$ammo_timed = 0;
$ammo_arrow = 0;


$bullet_name_list = Array(
    '0'	=> '12 Gauge Buckshot',
    '1'	=> '12 Gauge Slug',
	'2'	=> '5.56 Rifle Ammo',
	'3'	=> 'Beancan Grenade',
	'4'	=> 'F1 Grenade',
	'5'	=> 'Explosive 5.56 Rifle Ammo',
	'6'	=> 'Handmade Shell',
	'7'	=> 'High Velocity Arrow',
	'8'	=> 'HV 5.56 Rifle Ammo',
	'9'	=> 'HV Pistol Ammo',
	'10' => 'Incendiary 5.56 Rifle Ammo',
	'11' => 'Incendiary Pistol Bullet',
	'12' => 'Incendiary Rocket',
	'13' => 'Pistol Bullet',
	'14' => 'Rocket',
	'15' => 'Satchel Charge',
	'16' => 'Smoke Rocket WIP!!!!',
	'17' => 'Survey Charge',
	'18' => 'Timed Explosive Charge',
	'19' => 'Wooden Arrow'

);

foreach($bullet_name_list as $bullet_name_list){ 
	$sql = "SELECT id, player_id, bullet_name, bullets_fired, weapon_name FROM player_bullets_fired WHERE player_id = $steamid AND bullet_name = '$bullet_name_list'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {					
		$bulletname = $row["bullet_name"];	
		$bulletsfired = $row["bullets_fired"];	
		
		if ($bulletname == '12 Gauge Buckshot') { $ammo_buckshot = $ammo_buckshot + $bulletsfired; };
		if ($bulletname == '12 Gauge Slug') { $ammo_slug = $ammo_slug + $bulletsfired; };
		if ($bulletname == '5.56 Rifle Ammo') { $ammo_556 = $ammo_556 + $bulletsfired; };
		if ($bulletname == 'Beancan Grenade') { $ammo_beancan = $ammo_beancan + $bulletsfired; };
		if ($bulletname == 'F1 Grenade') { $ammo_f1 = $ammo_f1 + $bulletsfired; };
		if ($bulletname == 'Explosive 5.56 Rifle Ammo') { $ammo_556e = $ammo_556e + $bulletsfired; };		
		
		if ($bulletname == 'Handmade Shell') { $ammo_hs = $ammo_hs + $bulletsfired; };	
		if ($bulletname == 'High Velocity Arrow') { $ammo_arrowhv = $ammo_arrowhv + $bulletsfired; };	
		if ($bulletname == 'HV 5.56 Rifle Ammo') { $ammo_556hv = $ammo_556hv + $bulletsfired; };	
		if ($bulletname == 'HV Pistol Ammo') { $ammo_pistolhv = $ammo_pistolhv + $bulletsfired; };	
		if ($bulletname == 'Incendiary 5.56 Rifle Ammo') { $ammo_556i = $ammo_556i + $bulletsfired; };	
		if ($bulletname == 'Incendiary Pistol Bullet') { $ammo_pistoli = $ammo_pistoli + $bulletsfired; };	
		
		if ($bulletname == 'Incendiary Rocket') { $ammo_rocketi = $ammo_rocketi + $bulletsfired; };	
		if ($bulletname == 'Pistol Bullet') { $ammo_pistol = $ammo_pistol + $bulletsfired; };	
		if ($bulletname == 'Rocket') { $ammo_rocket = $ammo_rocket + $bulletsfired; };	
		if ($bulletname == 'Satchel Charge') { $ammo_satchel = $ammo_satchel + $bulletsfired; };	
		if ($bulletname == 'Smoke Rocket WIP!!!!') { $ammo_rocketwip = $ammo_rocketwip + $bulletsfired; };	
		if ($bulletname == 'Survey Charge') { $ammo_survey = $ammo_survey + $bulletsfired; };	

		if ($bulletname == 'Timed Explosive Charge') { $ammo_timed = $ammo_timed + $bulletsfired; };	
		if ($bulletname == 'Wooden Arrow') { $ammo_arrow = $ammo_arrow + $bulletsfired; };			
		};
	};	
};
$bullet_list = array
  (
  array("name" => "12 Gauge Buckshot","count" => $ammo_buckshot),
  array("name" => "12 Gauge Slug","count" => $ammo_slug),
  array("name" => "5.56 Rifle Ammo","count" => $ammo_556),
  array("name" => "Beancan Grenade","count" => $ammo_beancan),
  array("name" => "F1 Grenade","count" => $ammo_f1),
  array("name" => "Explosive 5.56 Rifle Ammo","count" => $ammo_556e),
  array("name" => "Handmade Shell","count" => $ammo_hs),
  array("name" => "High Velocity Arrow","count" => $ammo_arrowhv),
  array("name" => "HV 5.56 Rifle Ammo","count" => $ammo_556hv),
  array("name" => "HV Pistol Ammo","count" => $ammo_pistolhv),
  array("name" => "Incendiary 5.56 Rifle Ammo","count" => $ammo_556i),
  array("name" => "Incendiary Pistol Bullet","count" => $ammo_pistoli),
  array("name" => "Incendiary Rocket","count" => $ammo_rocketi),
  array("name" => "Pistol Bullet","count" => $ammo_pistol),
  array("name" => "Rocket","count" => $ammo_rocket),
  array("name" => "Satchel Charge","count" => $ammo_satchel),
  array("name" => "Smoke Rocket WIP!!!!","count" => $ammo_rocketwip),
  array("name" => "Survey Charge","count" => $ammo_survey),
  array("name" => "Timed Explosive Charge","count" => $ammo_timed),
  array("name" => "Wooden Arrow","count" => $ammo_arrow)
  );
//sorting all the ammo fired by order
function sortByOrder($a, $b) {
    return $b['count'] - $a['count'];
}

usort($bullet_list, 'sortByOrder');
//r($bullet_list);

?>
<!-- Gun firing chart -->

<!--Printing HTML-->

<div class="mp-rs-container">
  <div class="mp-rs-content">
  
	<div class='mp-rs-steaminfo'>
		<div class='mp-rs-gamename'>
		<?php echo $personaname; ?>
		</div>
		<div class='mp-rs-realname'>
		<?php echo $realname; ?>
		</div>
		
		<div class='mp-rs-gametime-container'>
		<div class='mp-rs-gametime-desciption'>Time played</div>
		<div class='mp-rs-gametime-information'><?php echo $current_onlinehours; ?>:<?php echo $current_onlinemins; ?></div>
		</div>
		<div class='mp-rs-lastlogin-container'>
		<div class='mp-rs-lastlogin-desciption'>Last Login</div>
		<div class='mp-rs-lastlogin-information'><?php echo $current_lastlogin; ?></div>
		</div>
	</div>
	<div class='mp-rs-avatarfull-container'>
		<img src='<?php echo $avatarfull; ?>' alt='#'>
	</div>
	
	<div class='mp-rs-gunstat-container'>
		<div class='mp-rs-gunstat-titre'>
			Ammunition Consumption
		</div>
		<div class='mp-rs-gunstat-graph'>
			<div id="chart"></div>	
		</div>
		<div class='mp-rs-gunstat-feed'>
			<?php
			$i = 0;
			foreach($bullet_list as $bullet_list){
				if($bullet_list["count"] > 0){
					echo"<div class='mp-rs-gunstat-details'>";
					echo"<div class='mp-rs-gunstat-amount'>".$bullet_list["count"]."</div><div class='mp-rs-gunstat-gunname'>".$bullet_list["name"]."</div>";
					echo"</div>";	
				}
			if (++$i == 8) break;		
			};
			?>
		</div>
	</div>

	<div class='mp-rs-record-container'>
		<div class='mp-rs-record-titre'>
				Longest kill Confirmed
		</div>
		<div class='mp-rs-record-details'>
			<div class='mp-rs-record-pvep'>PVP</div>
			<div class='mp-rs-record-gunname'><?php echo $killplayer_wep; ?></div>
			<div class='mp-rs-record-distance'><?php echo $killplayer_dis; ?></div>
			<div class='mp-rs-record-vitime'><a href='serverstatsrust.php?id=<?php echo $killplayer_vic_id; ?>' ><?php echo $killplayer_vic; ?></a></div>
		</div>
		<div class='mp-rs-record-details'>
			<div class='mp-rs-record-pvep'>PVE</div>
			<div class='mp-rs-record-gunname'><?php echo $killanimal_wep; ?></div>
			<div class='mp-rs-record-distance'><?php echo $killanimal_dis; ?></div>
			<div class='mp-rs-record-vitime'><?php echo $killanimal_ani; ?></div>
		</div>		
	</div>	
	
	<div class='mp-rs-resource-container'>
		<div class='mp-rs-resource-titre'>
				Resource collected
		</div>
		<div class='mp-rs-resource-warpl'>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalWood; ?></div><div class='mp-rs-resource-resname'>Wood</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalStones; ?></div><div class='mp-rs-resource-resname'>Stones</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalMetal; ?></div><div class='mp-rs-resource-resname'>Metal</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalSulfur; ?></div><div class='mp-rs-resource-resname'>Sulfur</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalQM; ?></div><div class='mp-rs-resource-resname'>High quality</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalCloth; ?></div><div class='mp-rs-resource-resname'>Cloth</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalAnimalFat; ?></div><div class='mp-rs-resource-resname'>Animal fat</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalLeather; ?></div><div class='mp-rs-resource-resname'>Leather</div>
			</div>
		</div>
		<div class='mp-rs-resource-warpr'>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalPork; ?></div><div class='mp-rs-resource-resname'>Pork</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalChickenBreast; ?></div><div class='mp-rs-resource-resname'>Chicken breast</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalBearMeat; ?></div><div class='mp-rs-resource-resname'>Bear meat</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalWolfMeat; ?></div><div class='mp-rs-resource-resname'>Wolf meat</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalBoneFragments; ?></div><div class='mp-rs-resource-resname'>Bone fragments</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalMushroom; ?></div><div class='mp-rs-resource-resname'>Mushroom</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalCorn; ?></div><div class='mp-rs-resource-resname'>Corn</div>
			</div>
			<div class='mp-rs-resource-details'>
				<div class='mp-rs-resource-amount'><?php echo $totalPumpkin; ?></div><div class='mp-rs-resource-resname'>Pumpkin</div>
			</div>
		</div>		
	</div>	
	
	<div class='mp-rs-hunt-container'>
		<div class='mp-rs-hunt-titre'>
				Hunting
		</div>
		<div class='mp-rs-hunt-details-f'>	
			<div class='mp-rs-hunt-animal'>Stag</div>
			<div class='mp-rs-hunt-killnumber'><?php echo $animalkill_Stag; ?></div>	
		</div>
		<div class='mp-rs-hunt-details'>	
			<div class='mp-rs-hunt-animal'>Horse</div>
			<div class='mp-rs-hunt-killnumber'><?php echo $animalkill_Horse; ?></div>	
		</div>
		<div class='mp-rs-hunt-details'>	
			<div class='mp-rs-hunt-animal'>Bear</div>
			<div class='mp-rs-hunt-killnumber'><?php echo $animalkill_Bear; ?></div>	
		</div>
		<div class='mp-rs-hunt-details'>	
			<div class='mp-rs-hunt-animal'>Boar</div>
			<div class='mp-rs-hunt-killnumber'><?php echo $animalkill_Boar; ?></div>	
		</div>
		<div class='mp-rs-hunt-details'>	
			<div class='mp-rs-hunt-animal'>Chicken</div>
			<div class='mp-rs-hunt-killnumber'><?php echo $animalkill_Chicken; ?></div>	
		</div>
	</div>	
	
	
	
	
	
	
	
	
	
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

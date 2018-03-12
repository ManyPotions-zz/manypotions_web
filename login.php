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
TEXT1 TEXT1 TEXT1 TEXT1 TEXT1 TEXT1 TEXT1 TEXT1 
		</div>
		
	
		
		<h1>Titre</h1>
	   


		
		<div class='mp-text-description'>

		
		
		
		
		<?php 
echo"<div class='mp-login-warp'>";
if(!isset($_SESSION['steamid'])) {
	echo "welcome guest! please login<br><br>";
    loginbutton(); //login button
    
}  else {
    include ('steamauth/userInfo.php');

    //Protected content
    echo "Welcome back " . $steamprofile['personaname'] . "</br>";
    echo "here is your avatar: </br>" . '<img src="'.$steamprofile['avatarfull'].'" title="" alt="" /><br>'; // Display their avatar!
    
    logoutbutton();
	
	
	
	// declaring info for DB morepotions_steaminfo
	$servername = "localhost";
	$username = "manypotions_steaminfouser";
	$password = "QQ2t4ng0d0wn";
	$dbname = "manypotions_steaminfo";

	// Create connection to my DB morepotions_steaminfo
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		 die("Connection failed: " . $conn->connect_error);
	}
	//Check for the steamid64
	$steamid64 = $steamprofile['steamid'];
	r($steamid64);

	//Check if steam id of the current user is on my DB,
	$sql1 = "SELECT steamid FROM playerinfo WHERE steamid = $steamid64";
	$result1 = $conn->query($sql1);

	if ($result1 ->num_rows > 0) {
	  // do something if steam ID est dans la DB
		echo "Steam ID est dans la DB";

				
		
		
		
	}
	else {
	  // do something else if Steam ID N'est PAS dans la DB
		echo "Steam ID N'est PAS dans la DB";
		
		$sql3 = "INSERT INTO playerinfo (steamid, money) VALUES ('$steamid64', '1000')";
		if ($conn->query($sql3) === TRUE) {
		echo "New record created successfully";
		} else {
		echo "Error: " . $sql3 . "<br>" . $conn->error;
		}
		
	}
	
	
	

//START SPINING WHEELL////
//get current balance
$sql4 = "SELECT money FROM  `playerinfo` WHERE steamid = $steamid64";
	$result4 = $conn->query($sql4);
		
	if ($result4 ->num_rows > 0) {
		// output data of each row
		 while($row4 = $result4->fetch_assoc()) {
			
			
			$currentmoney = $row4["money"];
			r($currentmoney);

		
		};
	};	
?>

  <p>Loot chance ( Gold = 1% Red = 3% Pink = 10% Green = 15% Blue = 27% Gray = 39% )</p>

  <select id="choicenumber" onchange="choiceNumberChanged()">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="25">25</option>
  </select>
  <button id="myBtnRandom" onclick="generateRandomLoot()">Open Box</button>
  <div id="randombox"></div>

  <script type="text/javascript">
     var bosterItemBack = [];
     var bosterItemFront = [];
     var lootToGenerate = 0;
     var lootCrates = [
      {"name":"Explosive Jar", "category":"gold","icon":"100px-Icon_explosive_jar-1", "dropRate":"1", "quantity":"1"},
      {"name":"Aloe Vera", "category":"blue","icon":"Icon_aloe_vera", "dropRate":"27", "quantity":"10"},
      {"name":"Bark", "category":"pink","icon":"Icon_bark-1",  "dropRate":"11", "quantity":"20"},
      {"name":"Bone", "category":"common","icon":"Icon_bone-1", "dropRate":"42", "quantity":"30"},
      {"name":"Twine", "category":"green","icon":"Icon_ingredient_rope", "dropRate":"16.5", "quantity":"20"},
      {"name":"Branch", "category":"blue","icon":"Icon_branch", "dropRate":"27", "quantity":"30"},
      {"name":"Brimstone", "category":"common","icon":"Icon_brimstone", "dropRate":"42", "quantity":"20"},
      {"name":"Coal", "category":"blue","icon":"Icon_coal", "dropRate":"27", "quantity":"30"},
      {"name":"Crystal", "category":"pink","icon":"Icon_crystal", "dropRate":"11", "quantity":"20"},
      {"name":"Demon Blood", "category":"red","icon":"Icon_demon_blood", "dropRate":"3", "quantity":"1"},
      {"name":"Glass", "category":"green","icon":"Icon_glass", "dropRate":"16.5", "quantity":"15"},
      {"name":"Web", "category":"blue","icon":"Icon_gossamer", "dropRate":"27", "quantity":"25"},
      {"name":"Hide", "category":"blue","icon":"Icon_hide-1", "dropRate":"27", "quantity":"20"},
      {"name":"Brick", "category":"green","icon":"Icon_ingredient_brick", "dropRate":"16.5", "quantity":"15"},
      {"name":"Hardened Brick","category":"red","icon":"Icon_ingredient_hardenedBrick", "dropRate":"3", "quantity":"20"},
      {"name":"Ichor", "category":"blue","icon":"Icon_ingredient_ichor", "dropRate":"27", "quantity":"15"},
      {"name":"Iron Reinforcement", "category":"green","icon":"Icon_ingredient_iron_reinforcement", "dropRate":"16.5", "quantity":"10"},
      {"name":"Tar", "category":"green","icon":"Icon_ingredient_pitch", "dropRate":"16.5", "quantity":"20"},
      {"name":"Plank", "category":"green","icon":"Icon_ingredient_plank", "dropRate":"16.5", "quantity":"20"},
      {"name":"Steel Reinforcement", "category":"pink","icon":"Icon_ingredient_steel_reinforcement", "dropRate":"11", "quantity":"5"},
      {"name":"Steelfire", "category":"green","icon":"Icon_ingredient_steelfire", "dropRate":"16.5", "quantity":"20"},
      {"name":"Iron Bar", "category":"green","icon":"Icon_iron_bar", "dropRate":"16.5", "quantity":"30"},
      {"name":"Iron Ore", "category":"blue","icon":"Icon_iron_ore-1", "dropRate":"27", "quantity":"50"},
      {"name":"Leather", "category":"green","icon":"Icon_leather", "dropRate":"16", "quantity":"15"},
      {"name":"Thick Leather", "category":"green","icon":"Icon_leather_thick", "dropRate":"16.5", "quantity":"15"},
      {"name":"Plant Fiber", "category":"common","icon":"Icon_plant_fiber-1", "dropRate":"42", "quantity":"30"},
      {"name":"Silk", "category":"green","icon":"Icon_silk", "dropRate":"16.5", "quantity":"15"},
      {"name":"Steel Bar", "category":"pink","icon":"Icon_steel_bar", "dropRate":"11", "quantity":"10"},
      {"name":"Stone", "category":"common","icon":"Icon_stone-1", "dropRate":"42", "quantity":"75"},
      {"name":"Thick Hide", "category":"blue","icon":"Icon_thick_hide-1", "dropRate":"27", "quantity":"20"},
      {"name":"TaskMaster", "category":"gold","icon":"Icon_thrall_taskmaster_converted", "dropRate":"0.5", "quantity":"1"},
      {"name":"Wood", "category":"common","icon":"Icon_wood-1", "dropRate":"42", "quantity":"75"}
    ];

    var goldenCrate = [];
    var redCrate = [];
    var pinkCrate = [];
    var greenCrate = [];
    var blueCrate = [];
    var commonCrate = [];

    lootCrates.forEach(function(crate) {
          switch(crate.category){
            case "gold":
              goldenCrate.push(crate);
              break;
            case "red":
              redCrate.push(crate);
              break;
            case "pink":
              pinkCrate.push(crate);
              break;
            case "green":
              greenCrate.push(crate);
              break;
            case "blue":
              blueCrate.push(crate);
              break;
            case "common":
              commonCrate.push(crate);
              break;
            default:
              console.log("unknown crate type:" + crate.category)
          }
    })

    //-----------------------------------------------------------------------------------
    //Fonction choiceNumberChanged
    //-----------------------------------------------------------------------------------
    function choiceNumberChanged() {
      var e = document.getElementById("choicenumber"); //refers to that select with all options    
      lootToGenerate = e.options[e.selectedIndex].value; // takes the one which the user will select...
    }

    //-----------------------------------------------------------------------------------
    // Generate the random crate
    //-----------------------------------------------------------------------------------

    function generateRandomLoot() {
      // Reset previous array
      bosterItemBack = [];
      bosterItemFront = [];
      // Generate as much crate as asked for
      for(var i = 0; i < lootToGenerate; i++){
          var obtainedCrate;
          var random = Math.floor((Math.random() * 100) + 1);
          
        if (random < 2) { //0-1 gold
          obtainedCrate = goldenCrate[Math.floor(Math.random()*goldenCrate.length)];
        } else if (random < 5) { //2-5 red
          obtainedCrate = redCrate[Math.floor(Math.random()*redCrate.length)];
        } else if (random < 16) { //6-16 pink
          obtainedCrate = pinkCrate[Math.floor(Math.random()*pinkCrate.length)];
        } else if (random < 32) { //17-32 green
          obtainedCrate = greenCrate[Math.floor(Math.random()*greenCrate.length)];
        } else if (random < 60) { //33-60 blue
          obtainedCrate = blueCrate[Math.floor(Math.random()*blueCrate.length)];
        } else if (random < 101) { // 61-100 common
          obtainedCrate = commonCrate[Math.floor(Math.random()*commonCrate.length)];
        }

        bosterItemBack.push(['<div  id="itemValue' + i + '" value="" class="item-box-back item-' + obtainedCrate.category + '-hover " onclick="myFunctionFlipOver(this)"><div class="item-look-back"><div class="item-back" style="background:url(images/chestclipart.gif) 0px -20px;background-repeat: no-repeat;background-size: 135px 135px;"></div></div></div>']);

        bosterItemFront.push(['<div id="item-' + i + '" class="item-box"><div class="item-look"><div class="item" style="background:url(images/conan/' + obtainedCrate.icon + '.png) 0px -20px;background-repeat: no-repeat;background-size: 135px 135px;"></div></div><div class="item-name ' + obtainedCrate.category + '">' + obtainedCrate.name + " | " + obtainedCrate.quantity + '</div></div>']);
      }

     //Removing commas from javascript array
      bosterItemBacknoCommas = bosterItemBack.join("");
      document.getElementById("randombox").innerHTML = bosterItemBacknoCommas;

    }
      
    //-----------------------------------------------------------------------------------
    //Fonction lootBox on clic
    //-----------------------------------------------------------------------------------

    function myFunctionFlipOver(elem) {
      //trouver le id du div q'on a cliquer
      var cardChoice = elem.id;
      //elever le text qui vien avec le id
      cardChoice = cardChoice.replace(/^\D+/g, '');
      //trouver le id corespond a quel carte dans la array bosterItemFront
      newItemFront = bosterItemFront[cardChoice];
      //suprime l'element using splice() a la position indiqer par cardChoice
      bosterItemBack.splice(cardChoice, 1);
      //remplacer la carte qui a ete suprimer par la meme de dos
      bosterItemBack.splice(cardChoice, 0, newItemFront);
           //Removing commas from javascript array
      bosterItemBacknoCommas = bosterItemBack.join("");

      document.getElementById("randombox").innerHTML = bosterItemBacknoCommas;
  
    }
	</script>
<?php


	// Show Steam ID from my DB
	$sql2 = "SELECT * FROM  `playerinfo` LIMIT 0 , 30";
	$result2 = $conn->query($sql2);
		
	if ($result2 ->num_rows > 0) {
		// output data of each row
		 while($row = $result2->fetch_assoc()) {
			
			
			$uniqueid = $row["uniqueid"];
			$steamid = $row["steamid"];
			$money = $row["money"];
			r($steamid);

		
		};
	};	
};
	echo"</div>";
	echo"<br>";


	?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
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

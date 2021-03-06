<?php
// begin all page head
// error reporting - optional
error_reporting(-1);
ini_set('display_errors', 'On');
// end error reporting
$title = "Federation";

session_name("SocialNetwork");
session_start();
require_once "./user.php";
require_once "./php/lib/dbhelper.php";


include("./php/inc/header.php");
// end all page head
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src='ajax/federation.js'></script>
<script type="text/javascript" src='ajax/purpose.js'></script>

<div class="leftContent">
<?php

if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id'])){

    echo '
   	<h2>CT310 Federation</h2> 
   	<script type="text/javascript">
		loggedon = 1;
		window.onload = init;
	</script>
   	<p id="federation">Site name and URL</p>
	
	';
	
	} else {
	
	echo '<h2>You must be logged in to view the Federation!</h2>';
	
	}
	
?>
</div>
<!--<div id="purpose">Hover over a group link and the purpose will be displayed.</div>-->

<?php include_once("php/inc/purposeContent.php"); //include_once("php/inc/rightContent.php"); ?>

<?php include("php/inc/footer.php"); ?>

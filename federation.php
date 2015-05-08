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

<div class="leftContent">
<?php

if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id'])){
	
	echo "<script type=\"text/javascript\">
		var loggedon = '1';
		window.onload = init;
	</script>
	
	<div class=\"leftContent\">
   	<h2>CT310 Federation</h2> 
   	<table id='federation'></table>
	</div>";
	
	} else {
	
	echo '<h2>You must be logged in to view the Federation!</h2>';
	
	}
	
?>
</div>



<?php include("php/inc/footer.php"); ?>

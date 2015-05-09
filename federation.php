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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src='ajax/federation.js'></script>

<div class="leftContent">
<p>
<?php

if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id'])){
	
	echo "
	<div class=\"leftContent\">
   	
   	<h2>CT310 Federation</h2> 
   	<script type=\"text/javascript\">
		loggedon = 1;
		window.onload = init;
	</script>
   	<div id=\"purpose\">Hover over a group link and the purpose will be displayed.</div>
   	<p id=\"federation\">Site name and URL</p>
	</div>
	
	";
	
	} else {
	
	echo '<h2>You must be logged in to view the Federation!</h2>';
	
	}
	
?>
<p>
</div>

<?php include_once("php/inc/rightContent.php"); ?>

<?php include("php/inc/footer.php"); ?>

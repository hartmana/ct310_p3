<?php
// begin all page head
// error reporting - optional
error_reporting(-1);
ini_set('display_errors', 'On');
// end error reporting
$title = "Home";

session_name("SocialNetwork");
session_start();
require_once "./user.php";
require_once "./php/lib/dbhelper.php";


include("./php/inc/header.php");
// end all page head
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src='ajax/federation.js'></script>
<script type="text/javascript">
        window.onload = init;
        var loggedon = '1';
</script>

<div class="leftContent">
    <h2>CT310 Federation</h2>
    
    <table id='federation'></table>

</div>

<?php include_once("php/inc/rightContent.php"); ?>

<?php include("php/inc/footer.php"); ?>


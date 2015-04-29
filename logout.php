<?php
session_name("SocialNetwork");
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
$title = "Log out";

require_once "./user.php";
require_once "./php/lib/dbhelper.php";
$dbh = new DBHelper();
$dbh->updateUserLoggedInStatus($_SESSION['user_id'], 0);
unset($_SESSION['user_name']);
unset($_SESSION['user_id']);
unset($_SESSION['starttime']);
session_destroy();
include("./php/inc/header.php");
?>

    <div class="leftContent">
        <p>Logout Successful.</p>
    </div>
<?php
include_once("php/inc/rightContent.php");
include("php/inc/footer.php");
?>
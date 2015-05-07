<?php
include_once("./php/lib/config.php");
include_once("./php/lib/dbhelper.php");
include_once("./php/lib/util.php");
require_once "./user.php";
$dbh = new DBHelper();
?>
<!DOCTYPE html>
<html lang="en">

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>


<head>
    <meta charset="UTF-8">
    <meta name="author" content=""/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link href="http://www.cs.colostate.edu/~ct310/yr2015sp/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $title ?> - Social Network</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div id="wrap">
    <header class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <h2>1337</h2>
                <!--                <img id="logo" src="images/l33t-logo-small.png" width="300" height="200" alt="L33T S4UC3" />-->
                <a href="index.php"> </a><br><br><br><br>
                <h4>  <?php echo "  pwd | " . $title; ?> </h4>
            </div>
            <div id="nav">
                <nav>
                    <ul>
                        <li><a href="index.php">./home</a></li>
                        <li><a href="search.php">./search</a></li>

                        <?php
                        if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id']))
                        {
                            $pending = $dbh->getPendingFriends($_SESSION['user_id'], 1);
                            if (count($pending) > 0)
                            {
                                ?>
                                <li><a id="friend-requests" href="./friend_requests.php">./requests</a></li>
                            <?php
                            }
                        }
                        if (isset($_SESSION['user_name']) && $dbh->isAdmin($_SESSION['user_id']) && $dbh->isUserLoggedIn($_SESSION['user_id']))
                        {
                            // add link to register users (isAdmin = true)
                            ?>
                            <li><a id="register-user" href="./register_user.php">./register</a></li>
                        <?php
                        } ?>

                        <?php
                        if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id'])){
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="logged-in-nav">

                <ul>
                    <li>Logged in as <a href="profile.php?user=<?php echo $_SESSION['user_name'];?>">
                            <?php echo $_SESSION['user_name'];?></a></li>
                    <li><a class="last" href="./logout.php">./quit </a></li>
                    <?php
                    }else{
                    ?>
                    <li><a href="./login.php">./login</a>
                        <?php
                        }
                        ?>
                </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="content">
		

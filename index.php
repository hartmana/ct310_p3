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

<div class="leftContent">
    <h2>Welcome to PomerFurball Social Network</h2>

    <p>PomerFurball is a social network founded by group 7... Suspendisse sodales accumsan erat a luctus. Nulla interdum
        elit vitae ultricies commodo. Suspendisse dignissim dolor vel accumsan hendrerit. Cras pharetra suscipit odio,
        quis pharetra nunc dignissim ultrices. Integer consectetur gravida fermentum. Ut tempus sem vel libero mollis,
        tincidunt vulputate leo fringilla. Proin ut orci vulputate, condimentum orci eu, convallis dolor. Quisque
        mattis, diam vitae elementum rutrum, turpis orci rutrum orci, vel maximus felis sapien sit amet nisl. Aliquam
        lacinia nisl eu pulvinar accumsan. Proin quis nisl sed nisi placerat molestie. In sagittis rhoncus mauris et
        hendrerit. Nunc vitae augue nec ante fermentum rutrum. In hac habitasse platea dictumst. Ut sit amet quam
        nulla.</p>

    <hr/>

    <h2>Feed</h2>

    <p>X is now friend of Y... Suspendisse sodales accumsan erat a luctus. Nulla interdum elit vitae ultricies commodo.
        Suspendisse dignissim dolor vel accumsan hendrerit. Cras pharetra suscipit odio, quis pharetra nunc dignissim
        ultrices. Integer consectetur gravida fermentum. Ut tempus sem vel libero mollis, tincidunt vulputate leo
        fringilla. Proin ut orci vulputate, condimentum orci eu, convallis dolor. Quisque mattis, diam vitae elementum
        rutrum, turpis orci rutrum orci, vel maximus felis sapien sit amet nisl. Aliquam lacinia nisl eu pulvinar
        accumsan. Proin quis nisl sed nisi placerat molestie. In sagittis rhoncus mauris et hendrerit. Nunc vitae augue
        nec ante fermentum rutrum. In hac habitasse platea dictumst. Ut sit amet quam nulla.</p>

    <hr/>
</div>

<?php include_once("php/inc/rightContent.php"); ?>

<?php include("php/inc/footer.php"); ?>


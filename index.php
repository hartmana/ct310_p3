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
				<h2>Welcome to 1337Book Social Network</h2>
				<p>1337Book 15 4 50c14l n37w0rk f0und3d by 6r0up 1337... 5u5p3nd1553 50d4l35 4ccum54n 3r47 4 luc7u5. null4 1n73rdum 3l17 v1743 ul7r1c135 c0mm0d0. 5u5p3nd1553 d16n1551m d0l0r v3l 4ccum54n h3ndr3r17. cr45 ph4r37r4 5u5c1p17 0d10, qu15 ph4r37r4 nunc d16n1551m ul7r1c35. 1n7363r c0n53c737ur 6r4v1d4 f3rm3n7um. u7 73mpu5 53m v3l l1b3r0 m0ll15, 71nc1dun7 vulpu7473 l30 fr1n61ll4. pr01n u7 0rc1 vulpu7473, c0nd1m3n7um 0rc1 3u, c0nv4ll15 d0l0r. qu15qu3 m47715, d14m v1743 3l3m3n7um ru7rum, 7urp15 0rc1 ru7rum 0rc1, v3l m4x1mu5 f3l15 54p13n 517 4m37 n15l. 4l1qu4m l4c1n14 n15l 3u pulv1n4r 4ccum54n. pr01n qu15 n15l 53d n151 pl4c3r47 m0l35713. 1n 54617715 rh0ncu5 m4ur15 37 h3ndr3r17. nunc v1743 4u6u3 n3c 4n73 f3rm3n7um ru7rum. 1n h4c h4b174553 pl4734 d1c7um57. u7 517 4m37 qu4m null4.</p>
				
				<hr/>
				
				<h2>Feed</h2>
				<p>X is now friend of Y... 5u5p3nd1553 50d4l35 4ccum54n 3r47 4 luc7u5. null4 1n73rdum 3l17 v1743 ul7r1c135 c0mm0d0. 5u5p3nd1553 d16n1551m d0l0r v3l 4ccum54n h3ndr3r17. cr45 ph4r37r4 5u5c1p17 0d10, qu15 ph4r37r4 nunc d16n1551m ul7r1c35. 1n7363r c0n53c737ur 6r4v1d4 f3rm3n7um. u7 73mpu5 53m v3l l1b3r0 m0ll15, 71nc1dun7 vulpu7473 l30 fr1n61ll4. pr01n u7 0rc1 vulpu7473, c0nd1m3n7um 0rc1 3u, c0nv4ll15 d0l0r. qu15qu3 m47715, d14m v1743 3l3m3n7um ru7rum, 7urp15 0rc1 ru7rum 0rc1, v3l m4x1mu5 f3l15 54p13n 517 4m37 n15l. 4l1qu4m l4c1n14 n15l 3u pulv1n4r 4ccum54n. pr01n qu15 n15l 53d n151 pl4c3r47 m0l35713. 1n 54617715 rh0ncu5 m4ur15 37 h3ndr3r17. nunc v1743 4u6u3 n3c 4n73 f3rm3n7um ru7rum. 1n h4c h4b174553 pl4734 d1c7um57. u7 517 4m37 qu4m null4.</p>
				
				<hr/>
</div>

<?php include_once("php/inc/rightContent.php"); ?>

<?php include("php/inc/footer.php"); ?>


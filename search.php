<?php
$title = "Search Users";
$userName = isset($_GET['user']) ? $_GET['user'] : "";
session_name("SocialNetwork");
session_start();
include("php/inc/header.php");
include("php/lib/files.php");

?>
    <div class="leftContent">
        <h2>Userlist</h2>
        <hr/>

        <div id="search-list">
            <?php
            /*
            $file = new files("users");
            $userlist = "";
            if ($file->exists()) {
                $userlist = $file->readFile();
            }else{
                print_r("ERROR");
            }
            $i = 1;

            foreach($userlist as $user){

                echo '<div class="profile-thumb">
                                <a href="profile.php?user=' . $i . '">
                                    <img src="images/profile' . $i++ . '.jpg" alt="profile"/>
                                    <span>' . $user[1] . '</span>
                                </a>
                        </div>';

            }
            */
            ?>
        </div>

        <!-- <div id="search-list">
            <div class="profile-thumb">
                <a href="user.php?user=leonardovolpatto">
                    <img src="images/profile5.jpg" alt="Profile 5's photo" />
                    <span>Stephen Hizzle</span>
                </a>
            </div>

            <div class="profile-thumb">

                <a href="user.php?user=leonardovolpatto">
                    <img src="images/profile4.jpg" alt="Profile 4's photo" />
                    <span>B. Gizzle</span>
                </a>
            </div>

            <div class="profile-thumb">
                <a href="user.php">
                    <img src="images/profile3.jpg" alt="Profile 3's photo" />
                    <span>Chuck Nizzle</span>
                </a>
            </div>

            <div class="profile-thumb">
                <a href="user.php">
                    <img src="images/profile2.jpg" alt="Profile 2's photo" />
                    <span>Stock Phizzle</span>
                </a>
            </div>

            <div class="profile-thumb">
                <a href="user.php">
                    <img src="images/profile1.jpg" alt="Profile 1's photo" />
                    <span>Name</span>
                </a>
            </div>
        </div> -->

    </div>

<?php
include_once("php/inc/rightContent.php")
?>

<?php
include("php/inc/footer.php");
?>
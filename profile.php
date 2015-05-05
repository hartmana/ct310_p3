<?php
$title = "Profile Page";

$userName = isset($_GET['user']) ? $_GET['user'] : "";
//$profile = isset($_POST['profile']) ? $_POST['profile'] : "";

session_name("SocialNetwork");
session_start();
include("php/inc/header.php");
include("php/lib/files.php");
include("php/lib/userOperations.php");

$helper = new DBHelper();
$util = new util();
$user = $dbh->getUserByUsername($userName);  //test db usage... Lisa

?>

<div class="leftContent">
    <?php

    //print_r($userName);
    if ($userName == "")
    {
        echo '<h2>username not received!</h2>';
    }
    else
    {

        if ($user != "")
        {

            echo '<h2>' . $user->first_name . ' ' . $user->last_name . '</h2>';
            $userimg = $dbh->getImageByUserID($user->user_id);
            echo '<img class="img" src="images/' . $userimg . '" alt="' . $userName . '\'s profile pic">';

            if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id']))
            {

                //add friend button
                if ($_SESSION['user_name'] != $user->user_name)
                {

                    $dbh1 = new PDO('sqlite:./php/lib/socialnetwork.db');
                    $query = "SELECT status FROM Friends WHERE user_id = '" . $user->user_id . "'";
                    $result = '';
                    foreach ($dbh1->query($query) as $row)
                    {
                        $result = $row['status'];
                        $dbh1 = null;
                    }

                    if ($result < 1)
                    {

                        echo '<form action="profile.php?user=' . $user->user_name . '" method="post">';
                        echo '<input type="submit" name="friend" value="Add friend" />';
                        echo '</form>';
                        if (isset($_POST['friend']))
                        {
                            $dbh->requestFriend($user->user_id, $_SESSION['user_id']);
                        }
                    }
                }
                //desc, gender, etc.
                $desc = $helper->getDescriptionByUserID($user->user_id);
                echo '<h4><b>Description: </b>' . $desc . '</h4>';
                $gender = $helper->getGenderByUsername($user->user_name);
                echo '<h5>Gender: ' . $gender . '</h5>';
                $mobile = $helper->getMobileByUsername($user->user_name);
                echo '<h5>Mobile: ' . $mobile . '</h5>';
                $email = $helper->getEmailByUsername($user->user_name);
                echo '<h5>Email: ' . $email . '</h5>';

            }
            else
            {
                echo '<h2>Only logged in users can view profile information!</h2>';
            }

            //$op = new userOperations($file);
            //$fileContents = $file->readFile();
            //print_r($fileContents);
            //$userInfo = $fileContents[$userName-1];
            //echo '<h2>' . $userInfo[1] . ' ' . $userInfo[2] . '</h2>';
            //echo '<img class="profile-pic" src="images/profile'. $userName . '.jpg" alt="' . $fileContents[0][2] . '\'s image profile">';
            //$description = $op->getDescription();
            // foreach($description as $value) {
            // 	echo '<p>' . $value . '</p><br/>';
            // }
            //echo '<p>' . $userInfo[3] . '</p>';

        }
        else
        {
            echo '<h2>Profile not found!</h2>';
        }
    }
    ?>


    <hr/>
    <?php
    if ($util->isIpValid())
    {
        if (isset($_SESSION['user_name']) && isset($user->user_name))
        {
            if ($_SESSION['user_name'] == $user->user_name)
            {
                echo '<p><a href="profileEdit.php?user=' . $userName . '">Edit your information</a></p>';
            }
        }
    }
    ?>
</div>

<?php
include_once("php/inc/rightContent.php")
?>

<?php
include("php/inc/footer.php")
?>

<?php
// need a way to determine if logged in user is the correct user to be able to edit this page.
// need to add option to edit auth question in this location
$title = "Edit Profile";
error_reporting(-1);
ini_set('display_errors', 'On');
// end error reporting

session_name("SocialNetwork");
session_start();
require_once "./user.php";
require_once "./php/lib/dbhelper.php";
include("php/lib/files.php");
include("php/lib/userOperations.php");

$dbh = new DBHelper();
$userName = isset($_GET['user']) ? $_GET['user'] : "";
$user = $dbh->getUserByUsername($userName);

if (!isset($_SESSION['user_name']) && !$dbh->isUserLoggedIn($_SESSION['user_id']))
{
    // cannot view edit page if not logged in
    header('Location:./login.php');
}
include("./php/inc/header.php");
$errors = array();
?>
<div class="leftContent"><?php
    if ($userName == "")
    {
        echo '<h2>Username not found!</h2>';
    }
    else
    {

        if ($user != "")
        {

            if (isset($_POST['message']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['gender']) && isset($_POST['mobile']) && isset($_POST['email']))
            {

                $description = util::sanitizeData($_POST['message']);
                $firstName = util::sanitizeData($_POST['firstname']);
                $lastName = util::sanitizeData($_POST['lastname']);
                $gender = $_POST['gender'];
                $mobile = util::sanitizeData($_POST['mobile']);
                $email = $_POST['email'];

                $dbh->updateUserDescriptionbyUserID($user->user_id, $description);
                $dbh->updateUserFirstNameByUserID($user->user_id, $firstName);
                $dbh->updateUserLastNameByUserID($user->user_id, $lastName);
                $dbh->updateUserGenderByUserID($user->user_id, $gender);
                $dbh->updateUserMobileByUserID($user->user_id, $mobile);
                $dbh->updateUserEmailByUserID($user->user_id, $email);

            }

            echo '<h2>' . $user->first_name . ' ' . $user->last_name . '</h2>';
            $userimg = $dbh->getImageByUserID($user->user_id);
            echo '<img class="profile-pic" src="images/' . $userimg . '" alt="' . $userName . '\'s image profile">';


            //image upload
            if ($_SESSION['user_name'] != "" && substr($_SERVER['REMOTE_ADDR'], 0, 6) == "129.82")
            {

                $max_file_size = 1000000;

                if (isset($_FILES["file"]))
                {
                    if ($_FILES["file"]["error"] == 0)
                    {
                        $type = explode("/", $_FILES["file"]["type"]);
                        if ($type[0] == "image")
                        {
                            if ($_FILES["file"]["size"] < $max_file_size)
                            {
                                $q = "SELECT * FROM Users";
                                $db = new PDO('sqlite:./php/lib/socialnetwork.db');
                                $ret = $db->query($q);
                                foreach ($ret as $r)
                                {
                                    if ($r['user_id'] == $_SESSION['user_id'])
                                    {
                                        move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
                                        chmod("images/" . $_FILES["file"]["name"], 0755);
                                        $query = "UPDATE Users SET image='" . $_FILES['file']['name'] . "' WHERE user_id='" . $r['user_id'] . "';";
                                        $db->exec($query);
                                    }
                                }
                                echo '<div class="alert alert-success"> Upload successful.</div>';
                            }
                            else
                            {
                                echo '<div class="alert alert-danger">File size too big</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger">Only images can be uploaded<div>';
                        }
                    }
                    else
                    {
                        echo 'Upload failed';
                    }
                }

                echo '<form action="profileEdit.php?user=' . $userName . '" method="post" enctype="multipart/form-data">';
                echo ' <div class="form-group"> Image: <input type="file" name="file"/>';
                echo '<input type="submit" name="button" id="button" class="btn btn-info" value="Submit new image">';
                echo '</div></form>';

            }
            else
            {
                echo 'Your IP must be whitelisted to upload an image file.';
            }

            /*if(isset($_FILES["file"])){
                if($_FILES["file"]["error"] == 0){
                    $type = explode ("/",$_FILES["file"]["type"]);
                }
            }*/

            /*$target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false){

                }
            }*/

            echo '<div class="wrap-textarea">';
            echo '<form method="post" action="profileEdit.php?user=' . $userName . '">';

            //names
            echo '<label for="firstname">First name</label>';
            echo '<input type="text" id="firstname" name="firstname" value="' . $user->first_name . '"/>';
            echo '<label for="lastname">Last name</label>';
            echo '<input type="text" id="lastname" name="lastname" value="' . $user->last_name . '"/>';

            //description
            echo '<label for="message">Description</label>';
            echo '<textarea name="message" id="message" rows="10" cols="50">';
            $desc = $dbh->getDescriptionByUserID($user->user_id);
            echo $desc;
            echo '</textarea>';

            //gender
            echo '<div>';
            echo '<label for="gender">Gender  </label>';
            echo '<select name="gender">';
            $gender = $dbh->getGenderByUsername($user->user_name);
            echo '<option value="">' . $gender . '</option>';
            echo '<option value="Male">Male</option>';
            echo '<option value="Female">Female</option>';
            echo '<option value="N/A">N/A</option>';
            echo '</select>';
            echo '</div>';

            //mobile
            echo '<div>';
            echo '<label for="mobile">Mobile number</label>';
            $mobile = $dbh->getMobileByUsername($user->user_name);
            echo '<input type="text" id="mobile" name="mobile" value="' . $mobile . '" required />';
            echo '</div>';

            //email
            echo '<div>';
            echo '<label for="email">Email</label>';
            $email = $dbh->getEmailByUsername($user->user_name);
            echo '<input type="text" id="email" name="email" value="' . $email . '" required />';
            echo '</div>';


            echo '<input type="submit" name="button" id="button" class="btn btn-info" value="Save"/>';
            echo '<a href="profile.php?user=' . $userName . '" >Go back</a>';

            if (isset($isSaved) && $isSaved)
            {
                echo '<div class="save-success"><h4>Successfully saved!</h4></div>';
            }
            echo '</form></div>';

        }
        else
        {
            echo '<h2>Profile not found!</h2>';
        }
    }
    ?>



    <hr/>
</div>


<?php

?>


<?php
include_once("php/inc/rightContent.php");
include_once("php/inc/footer.php");
?>

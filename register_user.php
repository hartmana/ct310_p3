<?php
error_reporting(-1);
ini_set('display_errors', 'On');
$title = "Register User";
session_name("SocialNetwork");
session_start();
require_once "./user.php";
require_once "./php/lib/dbhelper.php";
$dbh = new DBHelper();
$_SESSION['location'] = "register_user";
if (!isset($_SESSION['user_name']) || !$dbh->isAdmin($_SESSION['user_id']))
{
    header("Location: ./login.php");
}
include("./php/inc/header.php");
?>
<div class="leftContent"><?php
    $errors = array();
    if (isset($_POST['username']))
    {
        // $user_id = '1', $user_name = '', $user_type = 'user', $first_name = '', $last_name = '',
        // $password = '', $question_id = 1, $question_answer = '', $logged_in_status = 0
        $dbh->insertUser(
            $_POST['username'],
            $_POST['usertype'],
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['gender'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['password'],
            $_POST['question'],
            $_POST['questionanswer'],
            0,
            $_POST['description']
        );
    }

    ?>

    <?php
    if (count($errors) > 0)
    { ?>
        <div class="alert alert-danger">
            <h4>Please fix the following errors.</h4>
            <ul>
                <?php
                //This for each will load the key of the
                //array into the $field variable and the value
                //into the $error variable
                foreach ($errors as $field => $error)
                {
                    echo "<li>$error</li>";
                }
                ?>
            </ul>
        </div>
    <?php
    } //End if count($errors);
    ?>
    <form method="post" action="./register_user.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required/>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required/>
        </div>
        <div class="form-group">
            <label for="usertype">User Type:</label>
            <select id="usertype" name="usertype" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required/>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required/>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="na">N/A</option>
            </select>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile number:</label>
            <input type="text" id="mobile" name="mobile" required/>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required/>
        </div>
        <div class="form-group">
            <label for="question">Question:</label>
            <select name="question">
                <option value="">Select</option>
                <?php
                $count = 1;
                $questions = $dbh->getQuestionArray();
                foreach ($questions as $question)
                {
                    ?>
                    <option value="<?php echo $count; ?>"><?php echo $question; ?></option>;
                    <?php $count++;
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="questionanswer">Question Answer:</label>
            <input type="text" id="questionanswer" name="questionanswer" required/>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-info"/>
        </div>
    </form>
</div>

<?php
include_once("php/inc/rightContent.php");
include("php/inc/footer.php");
?>

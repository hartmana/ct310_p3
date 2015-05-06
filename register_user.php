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
        <fieldset>
            <legend>Create User</legend>
            <table class="form-table">
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required/></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" required/></td>
                </tr>
                <tr>
                    <td><label for="usertype">User Type:</label></td>
                    <td>
                        <select id="usertype" name="usertype" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="firstname">First Name:</label></td>
                    <td><input type="text" id="firstname" name="firstname" required/></td>
                </tr>
                <tr>
                    <td><label for="lastname">Last Name:</label></td>
                    <td><input type="text" id="lastname" name="lastname" required/></td>
                </tr>
                <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td>
                        <select name="gender">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="na">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="mobile">Mobile number:</label></td>
                    <td><input type="text" id="mobile" name="mobile" required/></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="text" id="email" name="email" required/></td>
                </tr>
                <tr>
                    <td><label for="question">Question:</label></td>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <td><label for="questionanswer">Question Answer:</label></td>
                    <td><input type="text" id="questionanswer" name="questionanswer" required/></td>
                </tr>
                <tr>
                    <td><label for="description">Description:</label></td>
                    <td><input type="text" id="description" name="description" required/></td>
                </tr>
                <tr>
                    <td><input type="submit" class="btn btn-info" value="Register User"/></td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>

<?php
include_once("php/inc/rightContent.php");
include("php/inc/footer.php");
?>

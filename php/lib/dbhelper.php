<?php
require_once "./user.php";

/*
NOTES
User fields:
user_type = user OR admin
logged_in_status = 0 (not logged in) OR 1 (logged in)
image = not sure, but I think it should be the name of the file (this can also be stored by username.jpg - was trying to think of options)

Function List:
void :: public function init()
int :: public function getNumberUsers()
int :: public function getNumberQuestions()
void :: public function insertUser($user_name, $user_type, $first_name, $last_name, $password, $question_id, $question_answer, $logged_in_status)
void :: public function insertQuestion($question_text)
user :: public function getUserByID($user_id)
string :: public function getDescriptionByUserID($user_id)
string :: public function getDescriptionByUsername($user_name)
void :: public function updateUserDescriptionByUserID($user_id, $description)
void :: public function updateUserDescriptionByUsername($user_name, $description)
string :: public function getImageByUserID($user_id)
string :: public function getImageByUsername($user_name)
void :: public function updateImageByUserID($user_id, $image)
void :: public function updateImageByUsername($user_name, $image)
user :: public function getUserByUsername($user_name)
user :: public function getUserByUsernameAndPassword($user_name, $password)
user[] :: public function getAllUsers()
boolean :: public function verifyUserByQuestion($user_name, $answer_text)
string :: public function getQuestionByID($question_id)
string[] :: public function getQuestionArray()
void :: public function updateUserQuestionByUserID($user_id, $question_id, $answer)
void :: public function updateUserQuestionByUsername($user_name, $question_id, $answer)
void :: public function updateUserLoggedInStatus($user_id, $logged_in_status)
boolean :: public function isUserLoggedIn($user_id)
user[] :: public function getLoggedInUsers()
user[] :: public function getLoggedInFriends($user_id)
user[] :: public function getPendingFriends($user_id, $status)
boolean :: public function checkFriendsWithIDs($user_id, $friend_id)
boolean :: public function checkFriendsWithNames($user_name, $friend_name)
boolean :: public function isAdmin($user_id)
*/

class DBHelper
{
    function __construct()
    {

    }

    public function init()
    {
        print_r("INIT BEGIN");
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
       
        $dbh->exec("CREATE TABLE IF NOT EXISTS Users (user_id INTEGER PRIMARY KEY ASC, user_name TEXT,
					user_type TEXT, first_name TEXT, last_name TEXT, gender TEXT, mobile TEXT, email TEXT, 
					password TEXT, question_id INTEGER, question_answer TEXT, logged_in_status INTEGER, 
					description TEXT, image TEXT);");
        print_r("INIT USERS");
        $this->insertUser('scat', 'user', 'Simons', 'Cat', 'Male', '303030303', 'simonscat@test', 'test123', '1', 'red', 0, 'Im a cat');
        $this->insertUser('admin', 'admin', 'Admin', 'istrator', '???', '970970970', 'admin@ct310grp7', 'password', '1', 'light', 0, 'Im an admin');

        print_r("INIT QUESTIONS");
        $sql = "CREATE TABLE IF NOT EXISTS Questions (question_id INTEGER PRIMARY KEY ASC, question_text TEXT);";
        $dbh->exec($sql);
        if ($this->getNumberQuestions() == 0)
        {
            $dbh->exec("INSERT INTO Questions (question_text) VALUES ('What is your favorite color?');");
            $dbh->exec("INSERT INTO Questions (question_text) VALUES ('What is your favorite place?');");
            $dbh->exec("INSERT INTO Questions (question_text) VALUES ('What is your favorite food?');");
            $dbh->exec("INSERT INTO Questions (question_text) VALUES ('What is your favorite foot?');");
        }
        print_r("INIT FRIENDS");
        // status:
        // 0 = not friends
        // 1 = pending
        // 2 = accepted
        $sql = "CREATE TABLE IF NOT EXISTS Friends (friend_id INTEGER PRIMARY KEY ASC, user_id INTEGER, friend_user_id INTEGER,
					status INTEGER)";
        $dbh->exec($sql);
        // insert friends list for testing
        $this->requestFriend(1, 2);
        print_r("INIT END");

        $dbh = null;
    }

    public function getNumberUsers()
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users";
        $count = 0;
        foreach ($dbh->query($sql) as $row)
        {
            $count++;
        }
        return $count;
    }

    public function getNumberQuestions()
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Questions";
        $count = 0;
        foreach ($dbh->query($sql) as $row)
        {
            $count++;
        }
        return $count;
    }

    public function insertUser($user_name, $user_type, $first_name, $last_name, $gender, $mobile, $email, $password, $question_id, $question_answer, $logged_in_status, $description)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Users WHERE user_name = '" . $user_name . "'";
        $count = 0;
        foreach ($dbh->query($sql) as $result)
        {
            $count++;
        }
        if ($count != 0)
        {
            //print_r("Cannot insert user that already exists.");
            echo "<div class=\"alert alert-danger\"> Cannot insert user that already exists </div>";
            $dbh = null;
        }
        else
        {
            $sql = "INSERT INTO Users (user_name, user_type, first_name, last_name, gender, mobile, email, password, question_id, question_answer, logged_in_status, description, image)
						VALUES ('" . $user_name . "', '" . $user_type . "', '" . $first_name
                . "', '" . $last_name . "', '" . $gender . "', '" . $mobile . "', '" . $email . "', '" . $password
                . "', " . $question_id . ", '" . $question_answer . "', " . $logged_in_status
                . ", '" . $description . "', '" . $user_name . ".jpg')";
            $dbh->exec($sql);
            //print_r("User inserted successfully");
            echo "<div class=\"alert alert-success\"> User inserted successfully </div>";
            $dbh = null;
        }
    }

    // not tested.
    public function insertQuestion($question_text)
    {
        $sql = "INSERT INTO Questions (question_text) VALUES ('" . $question_text . "');";
        try
        {
            $dbh2 = new PDO('sqlite:./php/db/socialnetwork.db');
            $dbh2->exec($sql);
            $dbh2 = null;
        } catch (PDOException $e)
        {
            ?><p>EXCEPTION: <?php $e->getMessage(); ?></p><?php
        }
    }

    public function getUserByID($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id = " . $user_id . ";";
        $result = $this->query($sql);
        if ($result === FALSE)
        {
            echo "<p>Error reading user</p>";
            $dbh = null;
            return NULL;
        }
        else
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->gender = $result['gender'];
            $user->mobile = $result['mobile'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $dbh = null;
            return $user;
        }
        $dbh = null;
    }

    // working
    public function getDescriptionByUserID($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id = " . $user_id . ";";
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return $result['description'];
        }
        $dbh = null;
    }

    // working
    public function getDescriptionByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_name = '" . $user_name . "';";
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return $result['description'];
        }
        $dbh = null;
    }

    public function updateUserFirstNameByUserID($user_id, $first_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET first_name = '" . $first_name . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    public function updateUserLastNameByUserID($user_id, $last_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET last_name = '" . $last_name . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }


    // have not tested.
    public function updateUserDescriptionByUserID($user_id, $description)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET description = '" . $description . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    public function updateUserGenderByUserID($user_id, $gender)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET gender = '" . $gender . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    public function updateUserMobileByUserID($user_id, $mobile)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET mobile = '" . $mobile . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    public function updateUserEmailByUserID($user_id, $email)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET email = '" . $email . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    // have not tested.
    public function updateUserDescriptionByUsername($user_name, $description)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET description = '" . $description . "' WHERE user_name = '" . $user_name . "'";
        $dbh->exec($sql);
    }

    // have not tested.
    public function getImageByUserID($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id = " . $user_id;
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return $result['image'];
        }
    }

    // have not tested.
    public function getImageByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_name = " . $user_name;
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return $result['image'];
        }
    }

    // have not tested.
    public function updateImageByUserID($user_id, $image)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET image = '" . $image . "' WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    // have not tested.
    public function updateImageByUsername($user_name, $image)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET image = '" . $image . "' WHERE user_name = " . $user_name;
        $dbh->exec($sql);
    }

    public function getUserByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_name = '" . $user_name . "';";
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->logged_in_status = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            //$user->gender = $result['gender'];
            //$user->mobile = $result['mobile'];
            //$user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $dbh = null;
            return $user;
        }
        $dbh = null;
        return null;
    }

    public function getUserByUsernameAndPassword($user_name, $password)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_name = '" . $user_name . "' AND password = '" . $password . "';";
        $user = new User();
        try
        {
            foreach ($dbh->query($sql) as $result)
            {
                $user->user_id = $result['user_id'];
                $user->user_name = $result['user_name'];
                $user->user_type = $result['user_type'];
                $user->first_name = $result['first_name'];
                $user->last_name = $result['last_name'];
                $user->gender = $result['gender'];
                $user->mobile = $result['mobile'];
                $user->email = $result['email'];
                $user->password = $result['password'];
                $user->question_id = $result['question_id'];
                $user->question_answer = $result['question_answer'];
                $user->logged_in_status = $result['logged_in_status'];
                $user->description = $result['description'];
                $user->image = $result['image'];
                $dbh = null;
                return $user;
            }
        } catch (Exception $e)
        {

        }
        $dbh = null;
        return null;
    }

    // have not tested.
    public function getAllUsers()
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users";
        $users = array();
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            //$user->gender = $result['gender'];
            //$user->mobile = $result['mobile'];
            //$user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $users[] = $user;
        }
        $dbh = null;
        return $users;
    }

    public function verifyUserByQuestion($user_name, $answer_text)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_name = '" . $user_name .
            "' AND question_answer = '" . $answer_text . "';";
        foreach ($dbh->query($sql) as $row)
        {
            return true;
        }
        return false;
    }

    public function getQuestionByID($question_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Questions WHERE question_id = " . $question_id;
        $result = '';
        foreach ($dbh->query($sql) as $row)
        {
            $result = $row['question_text'];
            $dbh = null;
            return $result;
        }
        $dbh = null;
        return $result;
    }

    public function getQuestionArray()
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Questions";
        $questions = array();
        foreach ($dbh->query($sql) as $row)
        {
            $questions[] = $row['question_text'];
        }
        $dbh = null;
        return $questions;
    }

    public function updateUserQuestionByUserID($user_id, $question_id, $answer)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET question_id = " . $question_id . ", question_answer = '" . $answer . "' WHERE user_id = '" . $user_id . "';";
        $dbh->exec($sql);
        $dbh = null;
    }

    public function updateUserQuestionByUsername($user_name, $question_id, $answer)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET question_id = " . $question_id . ", question_answer = '" . $answer . "' WHERE user_name = '" . $user_name . "';";
        $dbh->exec($sql);
        $dbh = null;
    }

    public function getGenderByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT gender FROM Users WHERE user_name = '" . $user_name . "'";
        $gender = "";
        foreach ($dbh->query($sql) as $result)
        {
            $gender = $result['gender'];
        }
        $dbh = null;
        return $gender;
    }

    public function getMobileByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT mobile FROM Users WHERE user_name = '" . $user_name . "'";
        $mobile = "";
        foreach ($dbh->query($sql) as $result)
        {
            $mobile = $result['mobile'];
        }
        $dbh = null;
        return $mobile;
    }

    public function getEmailByUsername($user_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT email FROM Users WHERE user_name = '" . $user_name . "'";
        $email = "";
        foreach ($dbh->query($sql) as $result)
        {
            $email = $result['email'];
        }
        $dbh = null;
        return $email;
    }

    // logged in status access
    public function updateUserLoggedInStatus($user_id, $logged_in_status)
    {
        //print_r($user_id . " " . $logged_in_status);
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "UPDATE Users SET logged_in_status = " . $logged_in_status . " WHERE user_id = " . $user_id;
        $dbh->exec($sql);
    }

    public function isUserLoggedIn($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id = " . $user_id;
        foreach ($dbh->query($sql) as $result)
        {
            if ($result['logged_in_status'] == 1)
            {
                $dbh = null;
                return true;
            }
        }
        $dbh = null;
        return false;
    }

    // have not tested.
    public function getLoggedInUsers()
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE logged_in_status = 1;";
        $users = array();
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->gender = $result['gender'];
            $user->mobile = $result['mobile'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $users[] = $user;
        }
        $dbh = null;
        return $users;
    }

    // have not tested
    public function getLoggedInFriends($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE logged_in_status = 1
					AND IN (SELECT friend_user_id FROM Friends WHERE user_id = " . $user_id . " AND status = 2);";
        $users = array();
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->gender = $result['gender'];
            $user->mobile = $result['mobile'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $users[] = $user;
        }
        $dbh = null;
        return $users;
    }

    public function getFriendsByUserID($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id IN (SELECT friend_user_id FROM Friends WHERE user_id = " . $user_id . " AND status = 2);";
        $users = array();
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->gender = $result['gender'];
            $user->mobile = $result['mobile'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $users[] = $user;
        }
        $dbh = null;
        return $users;
    }

    // have not tested.
    public function getPendingFriends($user_id, $status)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id IN (SELECT friend_user_id FROM Friends WHERE user_id = " . $user_id . " AND status = 1);";
        $users = array();
        foreach ($dbh->query($sql) as $result)
        {
            $user = new User();
            $user->user_id = $result['user_id'];
            $user->user_name = $result['user_name'];
            $user->user_type = $result['user_type'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->gender = $result['gender'];
            $user->mobile = $result['mobile'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->question_id = $result['question_id'];
            $user->question_answer = $result['question_answer'];
            $user->logged_in_status = $result['logged_in_status'];
            $user->description = $result['description'];
            $user->image = $result['image'];
            $users[] = $user;
        }
        $dbh = null;
        return $users;
    }

    // have not tested.
    public function checkFriendsWithIDs($user_id, $friend_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Friends WHERE (user_id = " . $user_id . " AND friend_user_id = " . $friend_id . ") " .
            " OR (user_id = " . $friend_id . " AND friend_user_id = " . $user_id . ")";
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return true;
        }
        $dbh = null;
        return false;
    }

    // have not tested.
    public function checkFriendsWithNames($user_name, $friend_name)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Friends WHERE (user_id = (SELECT user_id FROM Users WHERE user_name = '" . $user_name . "')
					AND friend_user_id = (SELECT user_id FROM Users WHERE user_name = '" . $friend_name . "'))
					OR 
					(user_id = (SELECT user_id FROM Users WHERE user_name = '" . $friend_name . "') 
					AND friend_user_id = (SELECT user_id FROM Users WHERE user_name = '" . $user_name . "')))";
        foreach ($dbh->query($sql) as $result)
        {
            $dbh = null;
            return true;
        }
        $dbh = null;
        return false;
    }

    public function requestFriend($user_id, $friend_user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Friends WHERE user_id = " . $user_id . " AND friend_user_id = " . $friend_user_id;
        if (!$this->checkFriendsWithIDs($user_id, $friend_user_id))
        {
            $dbh->exec("INSERT INTO Friends (user_id, friend_user_id, status) VALUES(" . $user_id . ", " . $friend_user_id . ", 1)");
        }
        $dbh = null;
    }

    public function acceptFriend($user_id, $friend_user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $dbh->exec("UPDATE Friends SET status = 2 WHERE user_id = " . $user_id . " AND friend_user_id = " . $friend_user_id . ";");
        $dbh->exec("INSERT INTO Friends (user_id, friend_user_id, status) VALUES(" . $friend_user_id . ", " . $user_id . " , 2)");
        $dbh = null;
    }

    public function rejectFriend($user_id, $friend_user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "DELETE FROM Friends WHERE user_id = " . $user_id . " AND friend_user_id = " . $friend_user_id;
        $dbh->exec($sql);
        $dbh = null;
    }

    public function isAdmin($user_id)
    {
        $dbh = new PDO('sqlite:./php/db/socialnetwork.db');
        $sql = "SELECT * FROM Users WHERE user_id = " . $user_id;
        foreach ($dbh->query($sql) as $result)
        {
            if ($result['user_type'] == "admin")
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}

?>

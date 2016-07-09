<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jyu Viole Grace
 * Date: 6/29/2016
 * Time: 9:44 PM
 */

// Connect to database
include("config.php");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $email = $pass = $passConfirm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $pass = test_input($_POST["pass"]);
    $passConfirm = test_input($_POST["passConfirm"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Checks for identical username
function identical_user($username, $db){
    $result = $db->query('SELECT username FROM users WHERE username = "' . $username . '"');

    if ($result->num_rows > 0) {
        // Returns true if there's an identical username
        return true;
    } else {
        // Returns false if username is available
        return false;
    }
}

// Sanitize and validate email
function verify_email($email)
{
    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        //echo("$email is a valid email address");
        return true;
    } else {
        //echo("$email is not a valid email address");
        return false;
    }

}

// Checks if password meets requirements (at least 8 char and contains at least one of each: uppercase, lowercase, special char, and number)
function valid_pass($isValid){
    $r1 = '/[A-Z]/';  //Uppercase
    $r2 = '/[a-z]/';  //lowercase
    $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/';  // 'special char'
    $r4 = '/[0-9]/';  //numbers

    if (preg_match_all($r1, $isValid, $o) < 1) return FALSE;

    if (preg_match_all($r2, $isValid, $o) < 1) return FALSE;

    if (preg_match_all($r3, $isValid, $o) < 1) return FALSE;

    if (preg_match_all($r4, $isValid, $o) < 1) return FALSE;

    if (strlen($isValid) < 8) return FALSE;

    return TRUE;
}

// Checks if both user input passwords are identical
function identical_pass($pass, $pass2)
{
    if ($pass === $pass2)
        return true;
    else
        return false;
}

// Adds user into database
function addUser($username, $email, $pass, $db)
{
    // create password hash with salt
    $passHashAndSalt = password_hash($pass, PASSWORD_BCRYPT);

    // send new user values to database
    $sql = "INSERT INTO users (username, email, passHashAndSalt)
    VALUES ('$username', '$email', '$passHashAndSalt')";

    // checks if new user values were successfully added to database
    if ($db->query($sql) === TRUE) {
        echo "New record created successfully.\n";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

}

// Checks all requirements, implementing previous methods all in one
function check_all($username, $email, $pass, $passConfirm, $db){
    if(identical_user($username, $db)) {
//        echo "Username taken";
        return false;
    }
    if(!verify_email($email)) {
  //      echo "Invalid email";
        return false;
    }
    if(!valid_pass($pass)) {
    //    echo "Password does not meet requirements";
        return false;
    }
    if(!identical_pass($pass,$passConfirm)) {
      //  echo "Passwords do not match";
        return false;
    }

    return true;
}
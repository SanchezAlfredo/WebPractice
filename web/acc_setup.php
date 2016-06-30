<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jyu Viole Grace
 * Date: 6/28/2016
 * Time: 8:40 PM
 */
include("config.php");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create password hash with salt
$passHashAndSalt = password_hash($_POST['pass'],PASSWORD_BCRYPT);

// send new user values to database
$sql = "INSERT INTO users (username, email, passHashAndSalt)
VALUES ('$_POST[username]', '$_POST[email]', '$passHashAndSalt')";

// checks if new user values were successfully added to database
if ($db->query($sql) === TRUE) {
    echo "New record created successfully.\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


print_r($_POST);


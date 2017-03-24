<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jyu Viole Grace
 * Date: 7/8/2016
 * Time: 9:41 PM
 */

// Connect to database
include("config.php");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username
$username = $db->real_escape_string($_POST['username']);

// Mysql query to select field username if it's equal to the username that we check '
$result = $db->query('SELECT username FROM users WHERE username = "' . $username . '"');

// If number of rows fields is bigger them 0 that means it's NOT available '
if ($result->num_rows > 0) {
    // And we send 0 to the ajax request
    echo false;
} else {
    // Else if it's not bigger then 0, then it's available '
    // And we send 1 to the ajax request
    echo true;
}
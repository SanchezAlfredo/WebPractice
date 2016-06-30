<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jyu Viole Grace
 * Date: 6/29/2016
 * Time: 9:44 PM
 */

//connect to database
include("config.php");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get the username
$username = $db->real_escape_string($_POST['username']);

//mysql query to select field username if it's equal to the username that we check '
$result = $db->query('select username from users where username = "'. $username .'"');

//if number of rows fields is bigger them 0 that means it's NOT available '
if(mysql_num_rows($result)>0){
    //and we send 0 to the ajax request
    echo 0;
}else{
    //else if it's not bigger then 0, then it's available '
    //and we send 1 to the ajax request
    echo 1;
}


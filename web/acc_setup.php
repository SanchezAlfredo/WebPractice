<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jyu Viole Grace
 * Date: 6/28/2016
 * Time: 8:40 PM
 */
include("config.php");
include("user_check.php");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Validates data to ensure it can be added
if(!check_all($username,$email,$pass,$passConfirm,$db)){
    header("Location: {$_SERVER['HTTP_REFERER']}");
    //$URL="http://alfredo.lazislacker.com/sign_up.html";
    //echo '<META HTTP-EQUIV="refresh" content="0; URL=' . $URL . '">';
    //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo "Account not created";
} else {
    //addUser($username,$email,$pass,$db);
    //$URL="http://alfredo.lazislacker.com/";
    //echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    header("Location:/sign_up_success.html");
    echo "Account created";

}



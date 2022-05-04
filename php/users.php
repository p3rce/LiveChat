<?php
session_start();
include_once "config.php";

$currentUser_uniqueID = $_SESSION['unique_id'];

$sql = mysqli_query($conn, "SELECT * FROM users");
$output = "";

if(mysqli_num_rows($sql) == 1) {
    //Only one user online (current user)
    $output = "No users available to chat 😪";
} elseif(mysqli_num_rows($sql) > 0) {
    include "data.php";
}

echo $output;


?>
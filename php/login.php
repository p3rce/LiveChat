<?php
session_start();

include_once "config.php";
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($email) && !empty($password)) {
    //Let's check users email and password
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");

    if(mysqli_num_rows($sql) > 0) {

        $row = mysqli_fetch_assoc($sql);

        //Check if the user is banned
        $isUserBanned = $row['banned'];

        if($isUserBanned == "YES") {
            //The user is banned
            echo "You have been banned for violating our TOS!";

        } else {
            //User is all good
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        }
    } else {
        echo "Email or password is incorrect!";
    }

} else {
    echo "All input fields are required!";
}

?>
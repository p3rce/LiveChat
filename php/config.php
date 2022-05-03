<?php

$conn = mysqli_connect("localhost", "root","","livechat_db");

if(!$conn) {
    echo "Database not connected" . mysqli_connect_error();
}


?>
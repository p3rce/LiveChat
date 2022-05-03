<?php
session_start();

include_once "config.php";
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    //Let's run through validation

    //First check email
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        //Next let's check if the email has already been used or not
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0) {
            echo "$email has already been used to sign up!";
        } else {
            //Let's check the profile pic

            //Check if the image is uploaded
            if(isset($_FILES['image'])) {

                $img_name = $_FILES['image']['name']; //Upload name
                $tmp_name = $_FILES['image']['tmp_name']; //Temp name used to save file in folder

                //Let's explode the image and get the extension
                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode); //here we will get the extension of the file uploaded

                $extensions= ['png', 'jpeg','jpg']; //Valid image extensions we are allowing

                if(in_array($img_ext, $extensions) === true) {
                    //Image is actually a valid image
                    $time = time(); //this will return us the current time. We will use this to generate a unique file name

                    $new_image_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name, "images/".$new_image_name)) {
                        $status = "Active now"; //User activity status
                        $random_id = rand(time(), 10000000);
                        $isUserVerified = "NO";

                        //Insert all user data inside table
                        $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status, verified)
                                            VALUES ({$random_id},'{$fname}','{$lname}','{$email}','{$password}','{$new_image_name}','{$status}','{$isUserVerified}')");
                        if($sql2) {
                            //Data has been inserted!!

                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if(mysqli_num_rows($sql3) > 0) {
                                $row = mysqli_fetch_assoc($sql3);

                                $_SESSION['unique_id'] = $row['unique_id']; // Using this session we used the user unique id we created
                                
                            }

                        } else {
                            echo "Something went wrong!";
                        }           
                    }

                } else {
                    echo "Only .png, .jpeg and .jpg files are allowed!";
                }

            } else {
                echo "Please upload an image file!";
            }
        }

    } else {
        echo "$email is not a valid email!";
    }

} else {
    echo "All input fields are required!";
}

?>
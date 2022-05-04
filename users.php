<?php
session_start();
if(!isset($_SESSION['unique_id'])) {
    header("location: login.php");
} else {
    $userUID = $_SESSION['unique_id'];
}
?>
<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="users">
            <?php
            include_once "php/config.php";
            $sql = mysqli_query($conn,"SELECT * FROM users WHERE unique_id = {$userUID}");

            if(mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
            }


            ?>
            <header>
                <div class="content">
                    <img src="php/images/<?php echo $row['img'];?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname'] . " " . $row['lname']; ?></span>
                        <p><?php echo $row['status'];?></p>
                    </div>

                </div>
                <a href="#" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select a user to start chatting</span>
                <input type="text" placeholder="Enter a name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                
            </div>
        </section>
    </div>

    <script src="javascript/users.js"></script>
    
</body>
</html>
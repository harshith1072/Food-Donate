<?php
include("login.php"); 
// if($_SESSION['loggedin']==true){
//     header("location:loginindex.html");
// }

if($_SESSION['name']==''){
	header("location: signup.php");
}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
        </ul>
    </nav>
</header>
<script>
    hamburger=document.querySelector(".hamburger");
    hamburger.onclick =function(){
        navBar=document.querySelector(".nav-bar");
        navBar.classList.toggle("active");
    }
</script>

<div class="profile">
    <p class="headingline" style="text-align: left;font-size:30px;">Profile</p>

    <div class="info" style="padding-left:10px;">
        <p>Name: <?php echo $_SESSION['name']; ?></p>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <p>Gender: <?php echo $_SESSION['gender']; ?></p>
        <a href="logout.php" style="float: left; margin-top: 6px; border-radius: 5px; background-color: #06C167; color: white; padding: 10px;">Logout</a>
    </div>

    <hr>

    <p class="heading">Your Donations</p>

    <div class="cards-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php
    $email = $_SESSION['email'];
    $query = "SELECT food_donations.*,delivery_persons.name AS namedelivery FROM food_donations LEFT JOIN  delivery_persons ON  food_donations.delivery_by=delivery_persons.Did WHERE food_donations.email='$email' ";
    $result = mysqli_query($connection, $query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="card" style="border: 1px solid #ddd; border-radius: 10px; width: 250px; padding: 20px; background-color: #f9f9f9;">
                    <h3 style="color: #06C167;">' . $row['food'] . '</h3>
                    <p><strong>Type:</strong> ' . $row['type'] . '</p>
                    <p><strong>Category:</strong> ' . $row['category'] . '</p>
                    <p><strong>Date/Time:</strong> ' . $row['date'] . '</p>
                    <p><strong>Delivered By:</strong> ' . ($row['namedelivery'] ? $row['namedelivery'] : 'None') . '</p>
                </div>';
        }
    }
    ?> 
</div>

</div>

</body>
</html>

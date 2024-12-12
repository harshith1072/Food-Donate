<?php

include("login.php");

// Redirect to sign-in page if not logged in
if (empty($_SESSION['name'])) {
    header("location: signin.php");
    exit();
}

$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost", "root", "", "demo");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $foodname = htmlspecialchars(trim($_POST['foodname']));
    $meal = htmlspecialchars(trim($_POST['meal']));
    $category = htmlspecialchars(trim($_POST['image-choice']));
    $quantity = (int)$_POST['quantity'];
    $phoneno = htmlspecialchars(trim($_POST['phoneno']));
    $district = htmlspecialchars(trim($_POST['district']));
    $address = htmlspecialchars(trim($_POST['address']));
    $name = htmlspecialchars(trim($_POST['name'])); 
    // Prepare SQL statement to insert the donation record
    $stmt = $connection->prepare("INSERT INTO food_donations (email, food, type, category, phoneno, location, address, name, quantity) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $emailid, $foodname, $meal, $category, $phoneno, $district, $address, $name, $quantity); 
    if ($stmt->execute()) {
        header("Location: profile.php"); // Correct syntax with quotes
        exit(); // Stop script execution after the redirect
    }
    // if ($stmt->execute()) {
    //     $donation_id = $stmt->insert_id;

    //     // Find an available delivery person
    //     $stmt_delivery = $connection->prepare("SELECT * FROM delivery_persons WHERE city = ? AND status = 'Available' LIMIT 1");
    //     $stmt_delivery->bind_param("s", $district);
    //     $stmt_delivery->execute();
    //     $result = $stmt_delivery->get_result();

    //     if ($result->num_rows > 0) {
    //         $delivery_boy = $result->fetch_assoc();
    //         $delivery_boy_name = $delivery_boy['name'];
    //         $delivery_boy_location = $delivery_boy['location'];
            

    //         // Assign delivery person to the donation
    //         $stmt_assign = $connection->prepare("UPDATE food_donations SET assigned_to = ?, delivery_by = ? WHERE Fid = ?");
    //         $stmt_assign->bind_param("ssi", $delivery_boy_name, $delivery_boy_name, $donation_id);
    //         $stmt_assign->execute();

    //         // Update delivery person's status to 'Busy'
    //         $stmt_update = $connection->prepare("UPDATE delivery_persons SET status = 'Busy' WHERE name = ?");
    //         $stmt_update->bind_param("s", $delivery_boy_name);
    //         $stmt_update->execute();

    //         // Redirect to donation details page
    //         header("location: donation_details.php?name=" . urlencode($delivery_boy_name) . "&location=" . urlencode($delivery_boy_location) . "&donation_id=" . $donation_id);
    //         exit();
    //     } else {
    //         echo '<script>alert("Donation saved, but no delivery person is currently available.");</script>';
    //     }
    // } else {
    //     echo '<script>alert("Error saving donation. Please try again.");</script>';
    // }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donate</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body style="background-color: #e1e1e1;"> <!-- Changed background to ash color -->
    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
                
                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required/>
                </div>
              
                <div class="radio">
                    <label for="meal">Meal type:</label><br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required/>
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>
                <div class="input">
                    <label for="food">Select the Category:</label><br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" alt="raw-food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" alt="cooked-food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" alt="packed-food">
                        </label>
                    </div>
                    <br>
                </div>
                <div class="input">
                    <label for="quantity">Quantity (number of persons / kg):</label>
                    <input type="text" id="quantity" name="quantity" required/>
                </div>
                <b><p style="text-align: center;">Contact Details</p></b>
                <div class="input">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required/>
                    </div>
                    <div>
                        <label for="phoneno">Phone No:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required/>
                    </div>
                </div>
                <div class="input">
                    <label for="district">District:</label>
                    <select id="district" name="district" style="padding:10px;">
                        <option value="kurnool">Kurnool</option>
                        <option value="hyderabad">Hyderabad</option>
                        <option value="warangal">Warangal</option>
                        <option value="ongole">Ongole</option>
                        <option value="guntur">Guntur</option>
                        <option value="mancherial">Mancherial</option>
                        <option value="karimnagar">Karimnagar</option>
                        <option value="vishakapatnam">Vishakapatnam</option>
                        <option value="vijayawada">Vijayawada</option>
                        <option value="nirmal">Nirmal</option>
                        <option value="kadapa">Kadapa</option>
                    </select>
                    <label for="address" style="padding-left: 10px;">Address:</label>
                    <input type="text" id="address" name="address" required/>
                </div>
                <div class="btn">
                    <button type="submit" name="submit" style="background-color: green;">Submit</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>

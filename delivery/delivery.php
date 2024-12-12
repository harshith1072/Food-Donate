<?php
ob_start();

// Include database connection
include "connect.php";
include "../connection.php";

// Check if user is logged in
if (empty($_SESSION['name'])) {
    header("Location: deliverylogin.php");
    exit;
}

$name = $_SESSION['name'];
$city = $_SESSION['city'];
$id = $_SESSION['Did'];

// Fetch location data
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $result = curl_exec($ch);
// $result = json_decode($result);

// if (!$result) {
//     die("Failed to fetch location data.");
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <script src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
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
            <li><a href="#home" class="active">Home</a></li>
            <!-- <li><a href="openmap.php">Map</a></li> -->
            <li><a href="deliverymyord.php">My Orders</a></li>
        </ul>
    </nav>
</header>
<script>
    document.querySelector(".hamburger").onclick = function() {
        document.querySelector(".nav-bar").classList.toggle("active");
    };
</script>

<style>
    .itm {
        background-color: white;
        display: grid;
    }
    .itm img {
        width: 400px;
        height: 400px;
        margin: auto;
    }
    p {
        text-align: center;
        font-size: 30px;
        color: black;
        margin-top: 50px;
    }
    @media (max-width: 767px) {
        .itm img {
            width: 350px;
            height: 350px;
        }
    }
</style>

<h2><center>Welcome <?php echo htmlspecialchars($name); ?></center></h2>

<div class="itm">
    <img src="../img/delivery.gif" alt="Delivery Illustration">
</div>

<div class="get">
<?php
// Fetch available orders
$sql = "
SELECT 
    fd.Fid AS Fid, fd.location AS cure, fd.name, fd.phoneno, fd.date, 
    fd.delivery_by, fd.address AS From_address,ad.address AS To_address
FROM 
    food_donations fd
LEFT JOIN 
    ngos ad ON fd.assigned_to = ad.NGO_ID 
WHERE 
    fd.location = '$city'
";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error fetching orders: " . mysqli_error($connection));
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle order assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['food'])) {
    $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);
    $delivery_person_id = mysqli_real_escape_string($connection, $_POST['delivery_person_id']);

    // Check if the order is already assigned
    $checkQuery = "SELECT * FROM food_donations WHERE Fid = '$order_id' AND delivery_by IS NOT NULL";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('This order has already been assigned to someone else.');</script>";
    } else {
        // Update order with delivery person
        $updateQuery = "UPDATE food_donations SET delivery_by = '$delivery_person_id' WHERE Fid = '$order_id'";
        $updateResult = mysqli_query($connection, $updateQuery);

        if ($updateResult) {
            echo "<script>alert('Order successfully assigned to you.');</script>";
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            echo "<script>alert('Error assigning order: " . mysqli_error($connection) . "');</script>";
        }
    }
}
?>
</div>

<!-- Table for showing orders -->
<div class="table-container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Pickup Address</th>
                    <th>Delivery address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phoneno']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['From_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['To_address']); ?></td>
                    <td>
                        <?php if (is_null($row['delivery_by'])): ?>
                            <form method="post" action="">
                                <input type="hidden" name="order_id" value="<?php echo $row['Fid']; ?>">
                                <input type="hidden" name="delivery_person_id" value="<?php echo $id; ?>">
                                <button type="submit" name="food">Take Order</button>
                            </form>
                        <?php elseif ($row['delivery_by'] == $id): ?>
                            Order assigned to you
                        <?php else: ?>
                            Order assigned to another delivery person
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

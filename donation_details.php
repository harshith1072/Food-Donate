<?php
// Retrieve query parameters from the URL
$delivery_boy_name = htmlspecialchars($_GET['name'] ?? 'Not Assigned');
$delivery_boy_location = htmlspecialchars($_GET['location'] ?? 'Unknown');
$donation_id = htmlspecialchars($_GET['donation_id'] ?? '');

// If location is provided as a string like 'latitude,longitude', split it into separate coordinates
$coordinates = explode(',', $delivery_boy_location);
$latitude = isset($coordinates[0]) && is_numeric($coordinates[0]) ? $coordinates[0] : null;
$longitude = isset($coordinates[1]) && is_numeric($coordinates[1]) ? $coordinates[1] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Details</title>
    <link rel="stylesheet" href="loginstyle.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #06C167;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #06C167;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Donation Details</h1>
        <p><strong>Donation ID:</strong> <?php echo $donation_id; ?></p>
        <p><strong>Assigned Delivery Boy:</strong> <?php echo $delivery_boy_name; ?></p>
        <p><strong>Delivery Boy Location:</strong> <?php echo $delivery_boy_location; ?></p>

        <!-- Map Display -->
        <div id="map"></div>

        <!-- Back to Home Link -->
        <a href="home.html">Back to Home</a>
    </div>

    <script>
        // Map initialization
        var latitude = <?php echo $latitude !== null ? $latitude : 'null'; ?>;
        var longitude = <?php echo $longitude !== null ? $longitude : 'null'; ?>;

        var mapCenter = [20.5937, 78.9629]; // Default location (India)

        // Check if valid coordinates are provided
        if (latitude !== null && longitude !== null) {
            mapCenter = [latitude, longitude];
        }

        // Create the map
        var map = L.map('map').setView(mapCenter, 13);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker if valid coordinates are provided
        if (latitude !== null && longitude !== null) {
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Delivery Boy Location')
                .openPopup();
        } else {
            // Display a message if location is not available
            var noLocationMessage = L.popup()
                .setLatLng(mapCenter)
                .setContent('Delivery location not available.')
                .openOn(map);
        }
    </script>
</body>
</html>

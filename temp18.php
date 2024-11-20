<?php

$servername = "localhost";  // Adjust this to your server settings

$username = "root";  // Your database username

$password = "";  // Your database password

$dbname = "shinesquad";  // Your database name

 

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

 

// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data

    $firstName = $_POST['firstName'];

    $email = $_POST['email'];

    $phone = $_POST['phone'];

    $location = $_POST['location'];

    $serviceField = $_POST['serviceField'];

    $message = $_POST['message'];

    $selectedDate = $_POST['selectedDate'];

    $selectedTime = $_POST['selectedTime'];

 

    // Insert booking data into the database

    $query = "INSERT INTO bookings (first_name, email, phone, location, service, message, selected_date, selected_time)

              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

 

    // Prepare statement

    if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ssssssss", $firstName, $email, $phone, $location, $serviceField, $message, $selectedDate, $selectedTime);

 

        if ($stmt->execute()) {

            // Redirect or show success message

            echo "Booking successfully submitted!";

        } else {

            echo "Error: " . $stmt->error;

        }

 

        // Close statement

        $stmt->close();

    } else {

        echo "Error: " . $conn->error;

    }

 

    // Close connection

    $conn->close();

}

?>
<?php
// Start session
session_start();

// Database credentials
$host = 'localhost'; // Change to your database host if different
$db = 'shinesquad'; // Name of your database
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Basic validation
    if (empty($email) || empty($password)) {
        echo "<p style='color: red;'>Both fields are required.</p>";
        exit();
    }

    // Prepare and execute query to get user data
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start a session and set user data (e.g., session variables)
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;

            // Redirect to home page after successful login
            echo "<p style='color: green;'>Login successful! Redirecting...</p>";
        } else {
            echo "<p style='color: red;'>Invalid password. Please try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>No account found with that email. Please try again.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

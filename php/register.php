<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "123";
    $dbname = "os_web";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password before storing

    // Check if the username is already taken
    $check_username_sql = "SELECT * FROM users WHERE username='$username'";
    $check_username_result = $conn->query($check_username_sql);

    if ($check_username_result->num_rows > 0) {
        $error = "Username already taken. Please choose a different username.";
    } else {
        // Insert user data into the database
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($insert_sql) === TRUE) {
            header("Location: index.html");
            echo "Registration successful. You can now <a href='index.html'>login</a>.";
        } else {
            $error = "Error: " . $conn->error;
            header("Location: register.html");
        }
    }

    // Close the database connection
    $conn->close();

    // Display any errors
    if (isset($error)) {
        echo "<p>Error: $error</p>";
    }
}
?>

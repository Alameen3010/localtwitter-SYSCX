<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $new_post = $_POST['new_post'];

    // Establish database connection
    include ('connection.php');

    session_start();

    if (isset ($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Prepare INSERT statement
        $sql = "INSERT INTO users_posts (student_id, new_post) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $new_post);

        // Execute INSERT statement
        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // Close statement and connection
    $stmt->close();
    $conn->close();
}

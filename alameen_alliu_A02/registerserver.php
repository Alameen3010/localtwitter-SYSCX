<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $DOB = $_POST['DOB'];
    $student_email = $_POST['student_email'];
    $program = $_POST['program'];

    // Validate and sanitize input data (not shown here for brevity)

    // Establish database connection
    include ('connection.php');

    session_start();

    // Insert data into user_info
    $sql = "INSERT INTO users_info (student_email, first_name, last_name, dob) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $student_email, $first_name, $last_name, $DOB);

    if ($stmt->execute()) {
        echo "New record created successfully" . "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $user_id = mysqli_insert_id($conn);

    $_SESSION['user_id'] = $user_id;

    // Insert data into user_program

    $sql = "INSERT INTO users_program (student_id, program) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $program);

    if ($stmt->execute()) {
        echo "New record created successfully" . "<br>";
        header("Location: profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Insert data into users_avatar
    $sql = "INSERT INTO users_avatar (student_id, avatar) VALUES (?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "New record created successfully" . "<br>";
        header("Location: profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Insert data into users_address
    $sql = "INSERT INTO users_address (student_id, street_number, street_name, city, province, postal_code) VALUES (?, 0, NULL, NULL, NULL, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "New record created successfully" . "<br>";
        header("Location: profile.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

<?php
session_start(); // Starting the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $DOB = $_POST['DOB'];
    $street_number = $_POST['street_number'];
    $street_name = $_POST['street_name'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $student_email = $_POST['student_email'];
    $program = $_POST['program'];
    $avatar = $_POST['avatar'];

    // Establish database connection
    include ('connection.php');

    if (isset ($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        echo ($user_id);
        // Update data in users_info table
        $sql = "UPDATE users_info SET student_email=?, first_name=?, last_name=?, dob=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $student_email, $first_name, $last_name, $DOB, $user_id);
        $stmt->execute();
        $stmt->close();

        // Update data in users_program table
        $sql = "UPDATE users_program SET program=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $program, $user_id);
        $stmt->execute();
        $stmt->close();

        // Update data in users_avatar table
        $sql = "UPDATE users_avatar SET avatar=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $avatar, $user_id);
        $stmt->execute();
        $stmt->close();

        // Update data in users_address table
        $sql = "UPDATE users_address SET street_number=?, street_name=?, province=?, postal_code=?, city=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $street_number, $street_name, $province, $postal_code, $city, $user_id);
        $stmt->execute();
        $stmt->close();

        echo "Profile updated successfully";
        header("Location: profile.php");
    }
    // Close database connection
    $conn->close();
}

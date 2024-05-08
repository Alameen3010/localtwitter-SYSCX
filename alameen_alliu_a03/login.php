<?php
session_start();
require_once ('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Register on SYSCX</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
   <header>
      <h1>SYSCX</h1>
      <p>Social media for SYSC students in Carleton University</p>
   </header>
   <nav>
      <ul>
         <!-- Visible to all users -->
         <li><a href="index.php">Home</a></li>

         <?php
         if (isset($_SESSION['student_id']) && $_SESSION['account_type'] == 0): ?>
            <!-- Visible only to Admin users -->
            <li><a href="user_list.php">User List</a></li>
         <?php endif; ?>

         <?php if (isset($_SESSION['student_id'])): ?>
            <!-- Visible only to logged-in users -->
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Log out</a></li>
         <?php else: ?>
            <!-- Visible only to guests -->
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
         <?php endif; ?>
      </ul>
   </nav>
   
   <main class="main">
      <section>
        
            <h2>Login</h2>
            <form method="post" action="">
                <label for="student_email">Email:</label>
                <input type="text" name="student_email" id="student_email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Login</button>
            </form>
            <?php
            // Handle the message display
            if (isset($_SESSION['message'])) {
                echo "<p>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }

            // // Check if already logged in
            // if (isset($_SESSION['student_id'])) {
            //     header("Location:index.php");
            //     exit;
            // }

            // Handle login attempt
            if (isset($_POST['student_email']) && isset($_POST['password'])) {
                $student_email = trim($_POST['student_email']);
                $password = trim($_POST['password']);
                // INNER JOIN users_program ON users_avatar.student_id = users_program.student_id 
                // INNER JOIN users_avatar ON users_permissions.student_id = users_avatar.student_id 
                // Prepare and bind
                if ($stmt = $conn->prepare("SELECT * FROM users_info INNER JOIN users_passwords ON users_info.student_id = users_passwords.student_id INNER JOIN users_permissions ON users_passwords.student_id = users_permissions.student_id WHERE users_info.student_email = ?")) {
                    $stmt->bind_param('s', $student_email);
                    // Execute and get result
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            // Verify password
                            if (password_verify($password, $row['password'])) {
                                echo "got in";
                                $_SESSION['student_id'] = $row['student_id'];
                                $_SESSION['student_email'] = $row['student_email'];
                                $_SESSION['first_name'] = $row['first_name'];
                                $_SESSION['last_name'] = $row['last_name'];
                                $_SESSION['account_type'] = $row['account_type'];
                                echo ($_SESSION['account_type']);

                                $stmt = $conn->prepare("SELECT * FROM users_info INNER JOIN users_avatar ON users_info.student_id = users_avatar.student_id INNER JOIN users_program ON users_avatar.student_id = users_program.student_id WHERE users_info.student_email = ?");
                                $stmt->bind_param('s', $student_email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();

                                $_SESSION['program'] = $row['program'];
                                $_SESSION['avatar'] = $row['avatar'];
                                echo $row['avatar'];
                                echo $row['program'];

                                header("Location:index.php");
                                exit;
                            } else {
                                $_SESSION['message'] = "Invalid email or password.";
                            }
                        } else {
                            $_SESSION['message'] = "Invalid email or password.";
                        }
                    } else {
                        $_SESSION['message'] = "Error executing query: " . $conn->error;
                    }
                    $stmt->close();
                } else {
                    $_SESSION['message'] = "Error preparing query: " . $conn->error;
                }
            }


            ?>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
      </section>
   </main>
   <div class="profile-bar">
   </div>
</body>

</html>
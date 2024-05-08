<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
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
    <section>
        <h2>User List</h2>
        <?php if ($_SESSION['account_type'] != 0): ?>
            <h1>Permission denied!!!</h1>
            <p><a href="index.php">Go home</a></p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Program</th>
                    <th>Account Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once ('connection.php');


                $sql = "SELECT * FROM users_info
                            LEFT JOIN users_program ON users_info.student_id = users_program.student_id
                            LEFT JOIN users_permissions ON users_info.student_id = users_permissions.student_id";

                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result->num_rows > 0) {

                    while ($user = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $user['student_id'] . "</td>";
                        echo "<td>" . $user['first_name'] . "</td>";
                        echo "<td>" . $user['last_name'] . "</td>";
                        echo "<td>" . $user['student_email'] . "</td>";
                        echo "<td>" . $user['program'] . "</td>";
                        echo "<td>" . ($user['account_type'] == 0 ? "Admin" : "Regular") . "</td>";
                        echo "</tr>";
                    }
                }
                ?>

            </tbody>
        </table>
        <?php endif; ?>
    </section>
   <div class="profile-bar">
      <?php if (isset($_SESSION['student_id'])): ?>
         <?php
         try {
            if (isset($_SESSION['student_id'])) {
               echo "<p>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</p>";
               echo "<p style='text-align: center;'><img src='images/img_avatar" . $_SESSION['avatar'] . ".png' style='max-width: 50px; max-height: 50px;'></p>";
               echo "<a href='#'>" . $_SESSION['student_email'] . "</a>";
               echo "<p>Program: <br>" . $_SESSION['program'] . "</p>";
            }
         } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
         }
         ?>
      <?php endif; ?>
   </div>
</body>

</html>
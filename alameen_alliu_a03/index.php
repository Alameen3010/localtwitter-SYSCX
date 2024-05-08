<?php
require ('connection.php'); // Assumes you have a file named connection.php with your database connection details
session_start();

// Check if the user is logged in, if not, redirect to login.php
if (!isset($_SESSION['student_id'])) {
   header("Location: login.php");
   exit();
}

if (isset($_POST['submit'])) {
   $user_id = $_SESSION['student_id'];
   $new_post = $_POST["new_post"];
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
   $stmt->close();
}
// Close statement and connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Welcome to SYSCX</title>
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

         <!-- Check if admin -->
         <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 0): ?>
            <li><a href="user_list.php">User List</a></li>
         <?php endif; ?>

         <!-- Check if user is logged in -->
         <?php if (isset($_SESSION['student_id'])): ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Log out</a></li>
         <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
         <?php endif; ?>
      </ul>
   </nav>
   <main class="main">
      <section class="content">

         <h2>Title of the Section</h2>

         <?php if (isset($_SESSION['student_id'])): ?>
            <form method="post" action="">
               <legend>
                  <span>New Post</span>
               </legend>
               <table>
                  <tr>
                     <td>

                        <textarea name="new_post" id="unique_id_for_textarea" cols="30" rows="10"
                           placeholder="What's happening?"></textarea>

                  </tr>
                  <tr>
                     <td>
                        <input type="submit" value="Post" name="submit">
                        <input type="reset" name="reset">
                     </td>
                  </tr>
               </table>
               <?php

               if (isset($_SESSION['student_id'])) {
                  $user_id = $_SESSION['student_id'];
                  // Prepare SQL statement to fetch user posts
                  $sql = "SELECT * FROM users_posts ORDER BY post_date DESC LIMIT 10";

                  $result = $conn->query($sql);

                  // Check if the query was successful
                  if ($result->num_rows > 0) {
                     echo '<table class="posts">';
                     while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>';
                        echo '<details>';
                        echo '<summary> Post ' . $row['post_id'] . '</summary>';
                        echo '<p>' . $row['new_post'] . '</p>';
                        echo '</details>';
                        echo '</td>';
                        echo '</tr>';
                     }
                     echo '</table>';
                  }
               }
               ?>
            </form>
         <?php endif; ?>
      </section>
   </main>
   <div class="profile-bar">
      <?php if (isset($_SESSION['student_id'])): ?>
         <?php
         try {
            if (isset($_SESSION['student_id'])) {
               $stmt = $conn->prepare("SELECT avatar FROM users_avatar WHERE student_id = ?");
               $stmt->bind_param("i", $_SESSION['student_id']);
               $stmt->execute();
               $result = $stmt->get_result();
               $avatar = $result->fetch_assoc()["avatar"];

               echo "<p>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</p>";
               echo "<p style='text-align: center;'><img src='images/img_avatar" . $avatar . ".png' style='max-width: 50px; max-height: 50px;' /></p>";
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
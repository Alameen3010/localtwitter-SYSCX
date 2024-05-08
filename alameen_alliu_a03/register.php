<?php
session_start();
require_once ('connection.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Retrieve and sanitize form data
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve and sanitize form data
      $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $DOB = filter_input(INPUT_POST, 'DOB', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $student_email = filter_input(INPUT_POST, 'student_email', FILTER_SANITIZE_EMAIL);
      $program = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = $_POST['password']; // No need to sanitize the password, as it will be hashed

      // Check if email exists
      $emailStmt = $conn->prepare("SELECT student_id FROM users_info WHERE student_email = ?");
      $emailStmt->bind_param("s", $student_email);
      $emailStmt->execute();
      $emailStmt->store_result();
      if ($emailStmt->num_rows > 0) {
         $_SESSION['message'] = "Email already exists. Please use a different email.";
      } else {
         // Hash the password
         $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

         // Start transaction
         $conn->begin_transaction();
         try {
            // Insert data into users_info
            $stmt = $conn->prepare("INSERT INTO users_info (student_email, first_name, last_name, dob) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $student_email, $first_name, $last_name, $DOB);
            $stmt->execute();
            $user_id = $conn->insert_id;
            $stmt->close();

            $_SESSION['student_id'] = $user_id;
            $_SESSION['student_email'] = $student_email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;


            // Insert data into users_program
            $stmt = $conn->prepare("INSERT INTO users_program (student_id, program) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $program);
            $stmt->execute();
            $stmt->close();

            $_SESSION['program'] = $program;

            // Insert data into users_avatar
            $stmt = $conn->prepare("INSERT INTO users_avatar (student_id, avatar) VALUES (?, 0)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['avatar'] = 0;

            // Insert data into users_passwords
            $stmt = $conn->prepare("INSERT INTO users_passwords (student_id, password) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $hashedPassword);
            $stmt->execute();
            $stmt->close();

            // Insert data into users_address
            $stmt = $conn->prepare ("INSERT INTO users_address (student_id, street_number, street_name, city, province, postal_code) VALUES (?, 0, NULL, NULL, NULL, NULL)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();


            $stmt = $conn->prepare("INSERT INTO users_permissions (student_id, account_type) VALUES (?, 1)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['account_type'] = 1;

            $conn->commit();
            header("Location: profile.php");
            exit();
         } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
         } finally {
            if (isset($emailStmt)) {
               $emailStmt->close();
            }
            $conn->close();
         }
      }
   }
}
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
            <li><a href="profile.php">Profile</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
      </ul>
   </nav>
   <main class="main">
      <section>
         <h2>Register a new profile</h2>
         <form action="" method="post" onsubmit="return validatePassword()">
            <fieldset>
               <legend><span>PERSONAL INFORMATION</span></legend>
               <table>
                  <tr>
                     <td>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name">
                     </td>
                     <td>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name">

                     </td>
                     <td>
                        <label for="DOB">Date of Birth:</label>
                        <input type="date" id="DOB" name="DOB">
                     </td>
                  </tr>
               </table>
            </fieldset>
            <fieldset>
               <legend><span>PROFILE INFORMATION</span></legend>
               <table>
                  <tr>
                     <td>
                        <label for="student_email">Email:</label>
                        <input type="email" id="student_email" name="student_email">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label for="program">Choose an option:</label>
                        <select id="program" name="program">
                           <option value="default" selected>Choose Program</option>
                           <option value="Computer Systems Engineering">Computer Systems Engineering</option>
                           <option value="Software Engineering">Software Engineering</option>
                           <option value="Communications Engineering">Communications Engineering</option>
                           <option value="Biomedical and Electrial">Biomedical and Electrial</option>
                           <option value="Electrical Engineering">Electrical Engineering</option>
                           <option value="Special">Special</option>
                        </select>
                     </td>
                  </tr>


                  <tr>
                     <td>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required />
                        <br>
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required />
                        <div id="password_error" style="color: red;"></div>
                     </td>
                  </tr>
                  <?php if (isset($_SESSION['message'])): ?>
                     <p class="error"><?php echo $_SESSION['message']; ?></p>
                     <?php unset($_SESSION['message']); ?>
                  <?php endif; ?>
                  <tr>
                     <td>
                        <input type="submit" value="Register">
                        <input type="reset">
                     </td>
                  </tr>
               </table>
            </fieldset>

            <script>
               function validatePassword() {
                  var password = document.getElementById("password").value;
                  var confirmPassword = document.getElementById("confirm_password").value;
                  if (password !== confirmPassword) {
                     document.getElementById("password_error").textContent = "Passwords do not match!";
                     return false;
                  }
                  return true;
               }
            </script>
         </form>
         <p>Already have an account? <a href="login.php">Login here</a>.</p>
      </section>
   </main>
   <div class="profile-bar">
   </div>
</body>

</html>
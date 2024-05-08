<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Update SYSCX profile</title>
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

         <?php if (isset($_SESSION['student_id']) && $_SESSION['account_type'] == 0): ?>
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
         <h2>Update Profile information</h2>
         
         <?php
         require_once ('connection.php'); // Using require_once to ensure the file is included and the script stops if it's not found.

         // Check if the user is logged in with 'student_id' according to the assignment instructions
         if (!isset($_SESSION['student_id'])) {
            header("Location: login.php");
            exit();
         }

         // The user is logged in
         $student_id = $_SESSION['student_id'];

         // Prepare and execute SQL statement to fetch user information
         $stmt = $conn->prepare("SELECT users_info.*, users_program.program, users_avatar.avatar, users_address.street_number, users_address.street_name, users_address.city, users_address.province, users_address.postal_code
                              FROM users_info
                              LEFT JOIN users_program ON users_info.student_id = users_program.student_id
                              LEFT JOIN users_avatar ON users_info.student_id = users_avatar.student_id
                              LEFT JOIN users_address ON users_info.student_id = users_address.student_id
                              WHERE users_info.student_id = ?");
         $stmt->bind_param("i", $student_id);
         $stmt->execute();
         $result = $stmt->get_result();

         if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $_SESSION["avatar"] = $user_data["avatar"];
            // Now you can use $user_data to populate the form fields
            // ...
         } else {
            echo "No user data found.";
            exit();
         }
         $stmt->close();
         ?>

         <?php

         // Handling POST request to update user information
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve and sanitize form data
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

            // Begin transaction
            $conn->begin_transaction();

            try {
               // Update users_info table
               $sql = "UPDATE users_info SET student_email=?, first_name=?, last_name=?, dob=? WHERE student_id=?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("ssssi", $student_email, $first_name, $last_name, $DOB, $student_id);
               $stmt->execute();
               $stmt->close();

               // Update users_program table
               $sql = "UPDATE users_program SET program=? WHERE student_id=?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("si", $program, $student_id);
               $stmt->execute();
               $stmt->close();

               // Update users_avatar table
               $sql = "UPDATE users_avatar SET avatar=? WHERE student_id=?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("ii", $avatar, $student_id);
               $stmt->execute();
               $stmt->close();

               // Update users_address table
               $sql = "UPDATE users_address SET street_number=?, street_name=?, city=?, province=?, postal_code=? WHERE student_id=?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("issssi", $street_number, $street_name, $city, $province, $postal_code, $student_id);
               $stmt->execute();
               $stmt->close();

               $conn->commit();

               echo "Profile updated successfully";
               header("Location: profile.php");
               exit();
               // Optionally redirect the user to a confirmation page or reload the profile page
            } catch (Exception $e) {
               $conn->rollback();
               echo "Error updating profile: " . $e->getMessage();
            }
         }
         ?>

         <form action="" method="post">
            <fieldset>
               <legend><span>Personal Information</span></legend>
               <table>
                  <tr>
                     <td>
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name"
                           value="<?php echo isset($user_data['first_name']) ? htmlspecialchars($user_data['first_name']) : ''; ?>" />
                        <br>
                     </td>
                     <td>
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name"
                           value="<?php echo isset($user_data['last_name']) ? htmlspecialchars($user_data['last_name']) : ''; ?>" />
                     </td>
                     <td>
                        <label for="DOB">DOB:</label>
                        <input type="date" name="DOB" id="DOB"
                           value="<?php echo isset($user_data['dob']) ? htmlspecialchars($user_data['dob']) : ''; ?>">
                     </td>
                  </tr>
               </table>
            </fieldset>

            <fieldset>
               <legend><span>Address</span></legend>
               <table>
                  <tr>
                     <td colspan="2">
                        <label for="street_number">Street Number:</label>
                        <input type="number" min="1" name="street_number" id="street_number"
                           value="<?php echo isset($user_data['street_number']) ? htmlspecialchars($user_data['street_number']) : ''; ?>">
                     </td>
                     <td>
                        <label for="street_name">Street Name:</label>
                        <input type="text" name="street_name" id="street_name"
                           value="<?php echo isset($user_data['street_name']) ? htmlspecialchars($user_data['street_name']) : ''; ?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label for="city">City:</label>
                        <input type="text" name="city" id="city"
                           value="<?php echo isset($user_data['city']) ? htmlspecialchars($user_data['city']) : ''; ?>">
                     </td>
                     <td>
                        <label for="province">Province:</label>
                        <input type="text" name="province" id="province"
                           value="<?php echo isset($user_data['province']) ? htmlspecialchars($user_data['province']) : ''; ?>">
                     </td>
                     <td>
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" id="postal_code"
                           value="<?php echo isset($user_data['postal_code']) ? htmlspecialchars($user_data['postal_code']) : ''; ?>">
                     </td>
                  </tr>
               </table>
            </fieldset>

            <fieldset>
               <legend><span>Profile Information</span></legend>
               <table>
                  <tr>
                     <td>
                        <label for="student_email">Email Address:</label>
                        <input type="text" name="student_email" id="student_email"
                           value="<?php echo isset($user_data["student_email"]) ? htmlspecialchars($user_data["student_email"]) : ''; ?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label for="program">Program:</label>
                        <select id="program" name="program">
                           <option <?php if ($user_data['program'] == "Choose Program") echo 'selected'; ?>>Choose Program</option>
                           <option <?php if ($user_data['program'] == "Computer Systems Engineering") echo 'selected'; ?>>Computer Systems Engineering</option>
                           <option <?php if ($user_data['program'] == "Software Engineering") echo 'selected'; ?>>Software Engineering</option>
                           <option <?php if ($user_data['program'] == "Communications Engineering") echo 'selected'; ?>>Communications Engineering</option>
                           <option <?php if ($user_data['program'] == "Biomedical and Electrical") echo 'selected'; ?>>Biomedical and Electrical</option>
                           <option <?php if ($user_data['program'] == "Electrical Engineering") echo 'selected'; ?>>Electrical Engineering</option>
                           <option <?php if ($user_data['program'] == "Special") echo 'selected'; ?>>Special</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label>Choose your Avatar:<br></label>
                        <?php
                        // Array of avatar options
                        $avatar_options = array(1, 2, 3, 4, 5);
                        foreach ($avatar_options as $option) {
                           $checked = (isset($user_data['avatar']) && $user_data['avatar'] == $option) ? 'checked' : '';
                           echo '<input type="radio" id="option' . $option . '" name="avatar" value="' . $option . '" ' . $checked . '>';
                           echo '<label for="option' . $option . '"><img src="images/img_avatar' . $option . '.png" alt="Avatar ' . $option . '"></label>';
                        }
                        ?>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <input type="submit">
                        <input type="reset">
                     </td>
                  </tr>
               </table>
            </fieldset>
         </form>
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
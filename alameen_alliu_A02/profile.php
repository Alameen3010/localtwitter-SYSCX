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
         <li><a href="index.php">Home</a></li>
         <li><a class="active" href="profile.php">Profile</a></li>
         <li><a href="register.php">Register</a></li>
         <li><a href="logout.php">Log out</a></li>
      </ul>
   </nav>
   <?php
   include ('connection.php');


   session_start();

   if (isset ($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];

      // Prepare SQL statement to fetch user information
      $sql = "SELECT * FROM users_info
               LEFT JOIN users_program ON users_info.student_id = users_program.student_id
               LEFT JOIN users_avatar ON users_info.student_id = users_avatar.student_id
               LEFT JOIN users_address ON users_info.student_id = users_address.student_id
               WHERE users_info.student_id = $user_id";

      $result = $conn->query($sql);

      // Check if the query was successful
      if ($result->num_rows > 0) {
         // Fetch user data
         $user_data = $result->fetch_assoc();

         // Assign fetched values to variables
         $first_name = $user_data['first_name'];
         $last_name = $user_data['last_name'];
         $DOB = $user_data['dob'];
         $street_number = $user_data['street_number'];
         $street_name = $user_data['street_name'];
         $city = $user_data['city'];
         $province = $user_data['province'];
         $postal_code = $user_data['postal_code'];
         $student_email = $user_data['student_email'];
         $program = $user_data['program'];
         $avatar = $user_data['avatar'];
      }
   } else {
      // Redirect to register.php if user ID is not set in session
      header("Location: register.php");
      exit();
   }

   // Close database connection
   $conn->close();
   ?>

   <main class="main">
      <section>
         <h2>Update Profile information</h2>
         <form action="profileserver.php" method="post">
            <fieldset>
               <legend><span>Personal Information</span></legend>
               <table>
                  <tr>
                     <td>
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
                     </td>
                     <td>
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
                     </td>
                     <td>
                        <label for="DOB">DOB:</label>
                        <input type="date" name="DOB" id="DOB" value="<?php echo $DOB; ?>">
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
                           value="<?php echo $street_number; ?>">
                     </td>
                     <td>
                        <label for="street_name">Street Name:</label>
                        <input type="text" name="street_name" id="street_name" value="<?php echo $street_name; ?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label for="city">City:</label>
                        <input type="text" name="city" id="city" value="<?php echo $city; ?>">
                     </td>
                     <td>
                        <label for="province">Province:</label>
                        <input type="text" name="province" id="province" value="<?php echo $province; ?>">
                     </td>
                     <td>
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" id="postal_code" value="<?php echo $postal_code; ?>">
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
                           value="<?php echo $student_email; ?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <label for="program">Program:</label>
                        <select id="program" name="program">
                           <option value="default" <?php if ($program == 'default')
                              echo 'selected'; ?>>Choose Program
                           </option>
                           <option value="Computer Systems Engineering" <?php if ($program == 'Computer Systems Engineering')
                              echo 'selected'; ?>>Computer Systems Engineering</option>
                           <option value="Software Engineering" <?php if ($program == 'Software Engineering')
                              echo 'selected'; ?>>Software Engineering</option>
                           <option value="Communications Engineering" <?php if ($program == 'Communications Engineering')
                              echo 'selected'; ?>>Communications Engineering</option>
                           <option value="Biomedical and Electrial" <?php if ($program == 'Biomedical and Electrial')
                              echo 'selected'; ?>>Biomedical and Electrial</option>
                           <option value="Electrical Engineering" <?php if ($program == 'Electrical Engineering')
                              echo 'selected'; ?>>Electrical Engineering</option>
                           <option value="Special" <?php if ($program == 'Special')
                              echo 'selected'; ?>>Special</option>
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
                           ?>
                           <input type="radio" id="option<?php echo $option; ?>" name="avatar"
                              value="<?php echo $option; ?>" <?php if ($avatar == $option)
                                    echo 'checked'; ?>>
                           <label for="option<?php echo $option; ?>"><img src="images/img_avatar<?php echo $option; ?>.png"
                                 alt="img_avatar<?php echo $option; ?>"></label>
                           <?php
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
      <p>First Last Name</p>
      <p style="text-align: center;"><img src="images/img_avatar3.png" style="max-width: 50px; max-height: 50px;"></p>
      <a href="#">student@cmail.carleton.ca</a>
      <p>Program: <br> Computer System Engineering</p>
   </div>
</body>

</html>
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
         <li><a href="index.php">Home</a></li>
         <li><a href="profile.php">Profile</a></li>
         <li><a class="active" href="register.php">Register</a></li>
         <li><a href="logout.php">Log out</a></li>
      </ul>
   </nav>
   <main class="main">
      <section>
         <h2>Register a new profile</h2>
         <form action="registerserver.php" method="post">
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
                        <input type="submit" value="Register">
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
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
         <li><a class="active" href="index.php">Home</a></li>
         <li><a href="profile.php">Profile</a></li>
         <li><a href="register.php">Register</a></li>
         <li><a href="logout.php">Log out</a></li>
      </ul>
   </nav>
   <main class="main">
      <section class="content">
         <h2>Title of the Section</h2>
         <form action="indexserver.php" method="post">

            <legend>
               <span>New Post</span>
            </legend>
            <table>
               <tr>
                  <td>
                     <textarea name="new_post" id="unique_id_for_textarea" cols="30"
                        rows="10">What happening?</textarea>

                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="submit" value="Post">
                     <input type="reset">
                  </td>
               </tr>

            </table>


            <?php
            include ('connection.php');

            session_start();


            if (isset ($_SESSION['user_id'])) {
               $user_id = $_SESSION['user_id'];
               // Prepare SQL statement to fetch user posts
               $sql = "SELECT * FROM users_posts WHERE student_id = ? ORDER BY post_id DESC LIMIT 5";

               $stmt = $conn->prepare($sql);
               $stmt->bind_param("i", $user_id);
               $stmt->execute();
               $result = $stmt->get_result();




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
               } else {
               }
            }
            $conn->close();
            ?>


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
<?php
/*
 File Name   : login.php
 Date        : 2/20/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Displays a login form, and sets session variables.
*/  
 // Required Files
 require_once('sessionManager.php');
 require_once('header.php');

 // Session Start
 session_start();
 
 // Display Site Logo
 displayLogoOnly();
 
 // If the login button was pressed...
 if (isset($_POST['login'])) {
  // If the login information was valid...
  if (login($_POST['email'], $_POST['password'])) {
   // redirect the user to the home page.
   header('Location: ' .  'home.php');
    
  // If the login information was invalid.
  } else {
   // display the login form and an error message.
   loginForm();
   echo "<br>Invalid email and/or password.";
  }
   
 // If the login button was not pressed...  
 } else {
  // display login form.
  loginForm();
 }
 
 // ********************************************
 // LOGIN FORM                                 *
 // Displays a login form.                     *
 // ********************************************
 function loginForm() {
  echo '
   <center>
   <form method="POST" action="login.php">
    <table>
     <tr>
      <td>EMAIL:</td>
      <td><input name="email" value=""></td>
     </tr><tr>
      <td>PASSWORD:</td>
      <td><input name="password" value=""></td>
     </tr><tr>
      <td><input type="submit" name="login" value="LOGIN"></td>
     </tr><tr>
      <td><a href="register.php">Create Account</a></td>
     </tr>
    </table>
   </form>   
   </center>';
 }
 
 /**********************************************************************************/
 /* FOR TESTING PURPOSES                                                           */
 /**********************************************************************************/
 echo "<br><br><b>For Testing Purposes:</b><br><a href='viewTables.php'>View Tables</a>";
 echo "<br><br><b>Login Accounts:</b><br><table><tr><td></td><td><b>email</b></td>" .
  "<td><b>password</b></td></tr><tr><td><b>TEACHER</b></td><td>teacher</td><td>"    .
  "teacher</td></tr><tr><td><b>STUDENT</b></td><td>student</td><td>student</td>"    .
  "</tr><tr><td><b>PEER REVIEWER</b></td><td>peer reviewer</td><td>peer reviewer"   .
  "</td></tr></table>";
 /**********************************************************************************/
 /* Not intended for the final release!                                            */
 /**********************************************************************************/
?>
<?php
/*
 File Name   : sessionManager.php
 Date        : 2/20/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Functions for managing the user session.
*/
 // Required Files
 require_once('Database.php');
 
 // ************************************************************************************
 // LOGIN -                                                                            *
 // Validates the login information passed to the function, then sets the session     *
 // variables. Returns the boolean value true if the login information was validated  *
 // and the session variables set, Returns false if the login information was not     *
 // valid.                                                                             *
 // PREREQ: Assumes the database does not allow duplicate emails.                      *
 // ************************************************************************************
 function login($email, $password) {
  $str = "
   SELECT * 
   FROM persons
   WHERE email='$email' AND password_hash='$password'";
  
  $rows = Database::query($str);
  
  if (mysql_num_rows($rows) == 1) {
   // Loggin information was valid.
   
   // Convert $rows to an associative array.
   $rec = mysql_fetch_assoc($rows);
   
   // Set the session variables.
   $_SESSION['id']            = $rec[id];
   $_SESSION['role']          = $rec[role];
   $_SESSION['secondaryRole'] = $rec[secondary_role];
   $_SESSION['firstName']     = $rec[first_name];
   $_SESSION['lastName']      = $rec[last_name];
   $_SESSION['email']         = $rec[email];
   
   return true;
  } else {
   // Login information is not valid due to no records being found.
   return false;
  }
 }
 
 // ************************************************************************************
 // LOGOUT                                                                             *
 // Removes all session data, and destroys the current session.                        *
 // ************************************************************************************
 function logout() {
  $_SESSION = array();
  session_destroy();
 }
?>
<?php
/*
 File Name   : register.php
 Date        : 2/15/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Allows the user to add a record to the persons table.
*/
 // Required Files
 require_once('header.php');
 require_once('personsUI.php');
 require_once('recordsManager.php');
 
 // Display Site Logo
 displayLogoOnly();

 // If the addPerson button was pressed...
 if (isset($_POST['addPerson'])) { echo "test";
  // add the person to the database.
  addPersons($_POST);
  
  // redirect to the landing page
  header('Location: home.php');
 } else {
  // else, display the entry form.
  addPersonsForm();
  echo "<p>&larr; <a href='home.php'>BACK</a></p>";
 }
?>

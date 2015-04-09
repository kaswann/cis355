<?php
/*
 File Name   : createLesson.php
 Date        : 2/28/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Creates a lesson and it's associated quiz.
  Redirects to the landing page when done.
*/
 // Required Files
 require_once('header.php');
 require_once('lessonsUI.php');
 require_once('recordsManager.php');
 
 // Display Header
 addHeader();
 
 // Check to see if the user is authorized to view this page.
 if (isset($_SESSION['role']) && $_SESSION['role'] == "Teacher") {
  // If the a new lesson was submitted...
  if (isset($_POST['submit'])) { 
   submitLesson();
   
   // Redirect to the landing page.
   header('Location: home.php');
  
  // If the cancel button was pressed...
  } elseif (isset($_POST['cancel'])) {
   // Redirect to the landing page.
   header('Location: home.php');
  
  // else, display a form for submitting a new lesson.
  } else {
   // Adds a javascript function for dynamically adding questions.
   dynamicQuestionForm();
  
   // Displays the Lesson entry form.
   lessonEntryForm();
  }
 // The user is not authorized to view this page.
 } else {
  // Redirect to the landing page.
  header('Location: home.php');
 }
?>
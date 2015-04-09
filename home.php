<?php
/*
 File Name   : home.php
 Date        : 2/20/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Teacheratti Landing Page
*/
 // Required Files
 require_once("header.php");
 require_once("recordsManager.php");
 require_once("lessonsUI.php");
 require_once("quizzesUI.php");
 require_once("attemptsUI.php");
 require_once("reviewsUI.php");
 
 // Add the header to the page.
 addHeader();
 
 // Require Active Session
 requireSession()
 
 // Displays a link that directs back to the homepage.
 function backButton() {
  echo "<p>&larr; <a href='home.php'>BACK</a></p>";
 }
 
 // Actions to be performed when no button has been pressed.
 function firstVisit() {
  // If the user is a teacher display the createLesson button.
  if ($_SESSION['role'] == "Teacher") {
   echo "
    <form method='POST' action='home.php'>
     <input type='submit' name='createLesson' value='Create New Lesson'>
    </form>";
  }
  
  // Display Lessons List
  listLessons();
 }
 
 // ******************************************************************************
 // LESSONS                                                                      *
 // ******************************************************************************
 // The View button from the List Lessons function was pressed.
 if (isset($_POST['selectLesson'])) {
  displayLesson($_POST['record']);
  backButton();
 }
  
 // The Edit Lesson button was pressed from the Display Lesson function.
 elseif (isset($_POST['editLesson'])) {
  updateLessonsForm();
  backButton();
 }
 
 // A Lessons Record update was submitted from the Update Lessons Form.
 elseif (isset($_POST['addLesson'])) {
  updateLessons($_POST);
  header("Location: home.php");
 }
 
 // The Create Lesson button was pressed.
 elseif (isset($_POST['createLesson'])) {
  header("Location: createLesson.php");
 }
   
 // The Delete Lesson button was pressed from the Display Lesson function.
 elseif (isset($_POST['deleteLesson'])) {
  deleteLessonsForm();
  header("Location: home.php");
 }
 
 // ******************************************************************************
 // QUIZZES                                                                      *
 // ******************************************************************************
 // The Edit Quiz button was pressed from the Display Lesson function.
 elseif (isset($_POST['editQuiz'])) {
  $record = getQuiz($_POST['lessonsID']);
  resubmitQuizForm($record);
 }
 
 // A Quizzes Record update was submitted from the Resubmit Quiz Form.
 elseif (isset($_POST['submitQuiz'])) {
  resubmitQuiz();
  header("Location: home.php");
 }
 
 // The Take Quiz button was pressed from the Display Lesson function.
 elseif (isset($_POST['takeQuiz'])) {
  takeQuizForm($_POST['lessonsID']);
 }
 
 
 // A quiz attempt was submitted.
 elseif (isset($_POST['submitAttempt'])) {
  submitAttempt($_POST);
  header("Location: home.php");
 }
 
 // The View Attempts button was pressed from the Display Lesson function.
 elseif (isset($_POST['viewAttempts'])) {
  viewAttempts($_POST['lessonsID']);
  backButton();
 }
 
 // ******************************************************************************
 // REVIEWS                                                                      *
 // ******************************************************************************
 // The Review Lesson button was pressed from the Display Lesson function.
 elseif (isset($_POST['reviewLesson'])) {
  submitReviewForm($_POST['lessonsID']);
  backButton();
 }
 
 // A lessons review was submitted.
 elseif (isset($_POST['submitReview'])) {
  addReviews($_POST);
  header("Location: home.php");
 } 
 
 // The Vie Reviews button was pressed from the Display Lesson function.
 elseif (isset($_POST['viewReviews'])) {
  viewReviews($_POST['lessonsID']);
  backButton();
 }
 
 // ******************************************************************************
 // FIRST VISIT                                                                  *
 // ******************************************************************************
 // No button was pressed...
 else
  firstVisit();
?>
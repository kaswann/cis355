<?php
/*
 File Name   : viewTables.php
 Date        : 3/2/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Displays all the records for a specified table within the database.
  Allows editing and deleting of records within the database.
*/
 // Required Class Files
 require_once('header.php');
 require_once('personsUI.php');
 require_once('lessonsUI.php');
 require_once('quizzesUI.php');
 require_once('questionsUI.php');
 require_once('optionsUI.php');
 require_once('attemptsUI.php');
 require_once('reportsUI.php');
 require_once('reviewsUI.php');
 require_once('responsesUI.php');
 require_once('recordsManager.php');
 
 // Display Logo
 displayLogoOnly();
 
 // Name of the current file.
 $fileName = basename($_SERVER['SCRIPT_FILENAME']);
 
 // Back Button
 function backButton() {
  echo "<p>&larr; <a href='$fileName'>BACK</a></p>";
 }
 
 // PERSONS TABLE
 if     (isset($_POST['viewPersons']))    { displayPersonsTable();   backButton(); }
 elseif (isset($_POST['updatePerson']))   { updatePeronsForm();      backButton(); }
 elseif (isset($_POST['deletePerson']))   { deletePersonsForm();     backButton(); }
 elseif (isset($_POST['addPerson']))      { updatePersons($_POST);
                                            displayPersonsTable();   backButton(); }
 
 // LESSONS TABLE
 elseif (isset($_POST['viewLessons']))    { displayLessonsTable();   backButton(); }
 elseif (isset($_POST['updateLesson']))   { updateLessonsForm();     backButton(); }
 elseif (isset($_POST['deleteLesson']))   { deleteLessonsForm();     backButton(); }
 elseif (isset($_POST['addLesson']))      { updateLessons($_POST);
                                            displayLessonsTable();   backButton(); }
 
 // QUIZZES TABLE
 elseif (isset($_POST['viewQuizzes']))    { displayQuizzesTable();   backButton(); }
 elseif (isset($_POST['updateQuiz']))     { updateQuizForm();        backButton(); }
 elseif (isset($_POST['deleteQuiz']))     { deleteQuizForm();        backButton(); }
 elseif (isset($_POST['addQuiz']))        { updateQuizzes($_POST);  
                                            displayQuizzesTable();   backButton(); }
  
 // QUESTIONS TABLE
 elseif (isset($_POST['viewQuestions']))  { displayQuestionsTable(); backButton(); }
 elseif (isset($_POST['updateQuestion'])) { updateQuestionsForm();   backButton(); }
 elseif (isset($_POST['deleteQuestion'])) { deleteQuestionsForm();   backButton(); }
 elseif (isset($_POST['addQuestion']))    { updateQuestions($_POST);
                                            displayQuestionsTable(); backButton(); }
 
 // OPTIONS TABLE
 elseif (isset($_POST['viewOptions']))    { displayOptionsTable();   backButton(); }
 elseif (isset($_POST['updateOption']))   { updateOptionsForm();     backButton(); }
 elseif (isset($_POST['deleteOption']))   { deleteOptionsForm();     backButton(); }
 elseif (isset($_POST['addOption']))      { updateOptions($_POST);
                                            displayOptionsTable();   backButton(); }
 
 // ATTEMPTS TABLE
 elseif (isset($_POST['viewAttempts']))   { displayAttemptsTable();  backButton(); }
 elseif (isset($_POST['updateAttempt']))  { updateAttemptsForm();    backButton(); }
 elseif (isset($_POST['deleteAttempt']))  { deleteAttemptsForm();    backButton(); }
 elseif (isset($_POST['addAttempt']))     { updateAttempts($_POST);
                                            displayAttemptsTable();  backButton(); }
 
 // REPORTS TABLE
 elseif (isset($_POST['viewReports']))    { displayReportsTable();   backButton(); }
 elseif (isset($_POST['updateReport']))   { updateReportsForm();     backButton(); }
 elseif (isset($_POST['deleteReport']))   { deleteReportsForm();     backButton(); }
 elseif (isset($_POST['addReport']))      { updateReports($_POST);
                                            displayReportsTable();   backButton(); }
 
 // REVIEWS TABLE
 elseif (isset($_POST['viewReviews']))    { displayReviewsTable();   backButton(); }
 elseif (isset($_POST['updateReview']))   { updateReviewsForm();     backButton(); }
 elseif (isset($_POST['deleteReview']))   { deleteReviewsForm();     backButton(); }
 elseif (isset($_POST['addReview']))      { updateReviews($_POST);
                                            displayReviewsTable();   backButton(); }
 
 // RESPONSES TABLE
 elseif (isset($_POST['viewResponses']))  { displayResponsesTable(); backButton(); }
 elseif (isset($_POST['updateResponse'])) { updateResponsesForm();   backButton(); }
 elseif (isset($_POST['deleteResponse'])) { deleteResponsesForm();   backButton(); }
 elseif (isset($_POST['addResponse']))    { updateResponses($_POST);
                                            displayResponsesTable(); backButton(); }
 
 // NO BUTTON WAS PRESSED
 else { 
  // Button Style Attributes
  $style = 'height:30px; width:150px;';
 
  // Display List of Buttons
  echo "
   <center>
   <form method='POST' action='$fileName'>
    <input type='submit' name='viewPersons'   value='View Persons Table'   style='$style' /><br>
    <input type='submit' name='viewLessons'   value='View Lessons Table'   style='$style' /><br>
    <input type='submit' name='viewQuizzes'   value='View Quizzes Table'   style='$style' /><br>
    <input type='submit' name='viewQuestions' value='View Questions Table' style='$style' /><br>
    <input type='submit' name='viewOptions'   value='View Options Table'   style='$style' /><br>
    <input type='submit' name='viewAttempts'  value='View Attempts Table'  style='$style' /><br>
    <input type='submit' name='viewReports'   value='View Reports Table'   style='$style' /><br>
    <input type='submit' name='viewReviews'   value='View Reviews Table'   style='$style' /><br>
    <input type='submit' name='viewResponses' value='View Responses Table' style='$style' /><br>
   </form>
   <a href='home.php'>Back to HOME</a>
   </center>  
  ";
 } 
?>
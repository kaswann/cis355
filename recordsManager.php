<?php
/*
 File Name   : recordsManager.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  - Contains functions for updating, adding, and deleting individual records.
  -- All functions are named the action you want to take, followed by the
   record type you want to act upon.
  -- All functions require an associative array passed to it containing all the
   record fields.
  - Contains a function that returns an array containing every record from a table.
  -- The function is named the table's name with the first letter being lower case, 
   followed by the word Array with the first A being upper case. EX: personsArray()
  - The following addRecord functions return the ID of the record that was inserted:
   Lessons, Quizzes, Questions, Attempts.
  - SPECIAL FUNCTIONS:
  -- SUBMIT LESSON:  Adds a lesson and quiz to the database.
  -- SUBMIT ATTEMPT: Adds the submitted attempt and associated responses to the database.
  -- RESUBMIT QUIZ:  Updates a quiz and its associated questions and options.
  -- GET PERSON:     Returns an associative array of the Persons Record with the
                      matching Persons ID.
  -- GET QUIZ:       Returns an associative array of the Quizzes Record with the 
                      matching Lessons ID.
  -- GET QUESTIONS:  Returns an array of associative arrays of Questions Records with
                      matching Quizzes ID.
  -- GET OPTIONS:    Returns an array of associative arrays of Options Records with
                      matching Questions ID.
*/
 // Required Files
 require_once('Database.php');
 require_once('Persons.php');
 require_once('Lessons.php');
 require_once('Quizzes.php');
 require_once('Questions.php');
 require_once('Options.php');
 require_once('Attempts.php');
 require_once('Responses.php');
 require_once('Reviews.php');
 require_once('Reports.php');
 
 // ***********************
 // PERSONS RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD PERSONS                                                                  *
 // Adds a persons record to the database.                                       *
 // ******************************************************************************
 function addPersons($record) {
  $person = new Persons(NULL, $record['role'], $record['secondaryRole'], 
   $record['firstName'], $record['lastName'], $record['email'], 
   $record['password'], $record['school']);
   
  $person->add();
 }
 
 // ******************************************************************************
 // UPDATE PERSONS                                                               *
 // Update a persons record within the database.                                 *
 // ******************************************************************************
 function updatePersons($record) {
  $person = new Persons($record['id'], $record['role'], $record['secondaryRole'], 
   $record['firstName'], $record['lastName'], $record['email'], 
   $record['password'], $record['school']);
   
  $person->update();
 }
 
 // ******************************************************************************
 // DELETE PERSONS                                                               *
 // Remove a persons record from the database.                                   *
 // ******************************************************************************
 function deletePersons($record) { 
  $person = new Persons($record['id'], $record['role'], $record['secondaryRole'], 
   $record['firstName'], $record['lastName'], $record['email'], 
   $record['password'], $record['school']);
   
  $person->delete();
 }
 
 // ******************************************************************************
 // PERSONS ARRAY                                                                *
 // Returns an array containing every record in the persons table.               *
 // ******************************************************************************
 function personsArray() {
  $str = "
   SELECT id, role, secondary_role, first_name, last_name, 
    email, password_hash, school
   FROM persons";
   
  // Obtain an array containing each record.
  $records = Database::query($str);
   
  // Array containing the records to be returned by the function.
  $output = array();
   
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']            = $row['id'];
   $output[$x]['role']          = $row['role'];
   $output[$x]['secondaryRole'] = $row['secondary_role'];
   $output[$x]['firstName']     = $row['first_name'];
   $output[$x]['lastName']      = $row['last_name'];
   $output[$x]['email']         = $row['email'];
   $output[$x]['passwordHash']  = $row['password_hash'];
   $output[$x]['school']        = $row['school'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ******************************************************************************
 // GET PERSON                                                                   *
 // Returns an associative array of the Persons Record with the                  *
 // matching Persons ID.                                                         *
 // ******************************************************************************
 function getPerson($personsID) {
  $str = "
   SELECT id, role, secondary_role, first_name, last_name, 
          email, password_hash, school
   FROM   persons
   WHERE  id = " . $personsID;
   
  $record = mysql_fetch_array(Database::query($str));
  
  $output['id']            = $record['id'];
  $output['role']          = $record['role'];
  $output['secondaryRole'] = $record['secondary_role'];
  $output['firstName']     = $record['first_name'];
  $output['lastName']      = $record['last_name'];
  $output['email']         = $record['email'];
  $output['passwordHash']  = $record['password_hash'];
  $output['school']        = $record['school'];
   
  return $output; 
 }
 
 // ***********************
 // LESSONS RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD LESSONS                                                                  *
 // Adds a lessons record to the database.                                       *
 // ******************************************************************************
 function addLessons($record) { 
  $lesson = new Lessons(NULL, $record['personsID'], $record['title'], 
   $record['subject'], $record['description'], $record['resources'], 
   $record['dateCreated'], $record['searchField']);
  
  return $lesson->add();
 }
 
 // ******************************************************************************
 // UPDATE LESSONS                                                               *
 // Update a lessons record within the database.                                 *
 // ******************************************************************************
 function updateLessons($record) {
  $lesson = new Lessons($record['id'], $record['personsID'], $record['title'], 
   $record['subject'], $record['description'], $record['resources'], 
   $record['dateCreated'], $record['searchField']);
   
  $lesson->update();
 }
 
 // ******************************************************************************
 // DELETE LESSONS RECORD                                                        *
 // Remove a lessons record from the database.                                   *
 // ******************************************************************************
 function deleteLessons($record) {
  $lesson = new Lessons($record['id'], $record['personsID'], $record['title'], 
   $record['subject'], $record['description'], $record['resources'],
   $record['dateCreated'], $record['searchField']);

  $lesson->delete();
 }
 
 // ******************************************************************************
 // LESSONS ARRAY                                                                *
 // Returns an array containing every record in the lessons table.               *
 // ******************************************************************************
 function lessonsArray() {
  $str = "
   SELECT id, title, subject, description, resources, persons_ID, 
    date_created, search_field
   FROM lessons";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
    
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']          = $row['id'];
   $output[$x]['personsID']   = $row['persons_ID'];
   $output[$x]['title']       = $row['title'];
   $output[$x]['subject']     = $row['subject'];
   $output[$x]['description'] = $row['description'];
   $output[$x]['resources']   = $row['resources'];
   $output[$x]['dateCreated'] = $row['date_created'];
   $output[$x]['searchField'] = $row['search_field'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ******************************************************************************
 // SUBMIT LESSON                                                                *
 // Adds the submitted lesson and associated quiz to the database.               *
 // ******************************************************************************
 function submitLesson() {
  // Associative array containing the data to be passed to the records manager.
  $recordArray                = $_POST;
  $recordArray['personsID']   = $_SESSION['id'];
  $recordArray['dateCreated'] = date("Y-m-d h:i:sa");
  
  // Add lesson to the database.
  $recordArray['title']       = $recordArray['lessonTitle'];
  $recordArray['description'] = $recordArray['lessonDescription'];
  $recordArray['lessonsID']   = addLessons($recordArray);
  
  // Add quiz to the database.
  $recordArray['title']       = $recordArray['quizTitle'];
  $recordArray['description'] = $recordArray['quizDescription'];
  $recordArray['quizzesID']   = addQuizzes($recordArray);
  
  // Add questions to the database.
  $questionCounter = 0;
  foreach ($_POST['questions'] as $question)  {
   // for use in options array
   $optionCounter = 0;

   // Correct Option
   $correctOption = $_POST['answers'][$questionCounter];   
   
   // Insert Question
   $rec['quizzesID']   = $recordArray['quizzesID'];
   $rec['question']    = $question;
   $rec['questionsID'] = addQuestions($rec);
   
   // For each option of the current question...
   foreach ($_POST['options'][$questionCounter] as $option) {
    // Determine if option is correct.
    if ($optionCounter != $correctOption)
     $rec['correctOption'] = 0;
    else
     $rec['correctOption'] = 1;
    
    // Add option to the database.
    $rec['option']      = $option;
    addOptions($rec);
        
    // Increment Option Counter
    $optionCounter++;
   }

   // Increment Question Counter
   $questionCounter++;
  }
 }
 
 // ***********************
 // QUIZZES RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD QUIZZES                                                                  *
 // Adds a quizzes record to the database.                                       *
 // ******************************************************************************
 function addQuizzes($record) {
  $quiz = new Quizzes(NULL, $record['lessonsID'], $record['attemptsAllowed'], 
   $record['title'], $record['description']);
   
  return $quiz->add();  
 }
 
 // ******************************************************************************
 // UPDATE QUIZZES                                                               *
 // Update a quizzes record within the database.                                 *
 // ******************************************************************************
 function updateQuizzes($record) {
  $quiz = new Quizzes($record['id'], $record['lessonsID'], $record['attemptsAllowed'], 
   $record['title'], $record['description']);
   
  $quiz->update();
 }
 
 // ******************************************************************************
 // DELETE QUIZZES                                                               *
 // Remove a quizzes record from the database.                                   *
 // ******************************************************************************
 function deleteQuizzes($record) { 
  $quiz = new Quizzes($record['id'], $record['lessonsID'], $record['attemptsAllowed'], 
   $record['title'], $record['description']);
   
  $quiz->delete();
 }
 
 // ******************************************************************************
 // QUIZZES ARRAY                                                                *
 // Returns an array containing every record in the quizzes table.               *
 // ******************************************************************************
 function quizzesArray() {
  $str = "
   SELECT id, lessons_id, attempts_allowed, title, description
   FROM quizzes";
   
  // Obtain an array containing each record.
  $records = Database::query($str);
   
  // Array containing the records to be returned by the function.
  $output = array();
   
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']              = $row['id'];
   $output[$x]['lessonsID']       = $row['lessons_id'];
   $output[$x]['attemptsAllowed'] = $row['attempts_allowed'];
   $output[$x]['title']           = $row['title'];
   $output[$x]['description']     = $row['description'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ******************************************************************************
 // GET QUIZ                                                                     *
 // Returns an associative array of the Quizzes Record with                      *
 // the matching Lessons ID.                                                     *
 // ******************************************************************************
 function getQuiz($lessonsID) {
  $str = "SELECT id, lessons_id, attempts_allowed, title, description
   FROM quizzes WHERE lessons_id = $lessonsID";
  
  $record = Database::query($str); 
  $result = mysql_fetch_array($record);
  
  $output['id']              = $result['id'];
  $output['lessonsID']       = $result['lessons_id'];
  $output['attemptsAllowed'] = $result['attempts_allowed'];
  $output['title']           = $result['title'];
  $output['description']     = $result['description'];
  
  return $output;
 }
 
 // ******************************************************************************
 // RESUBMIT QUIZ                                                                *
 // Updates the information, questions, and options of a quiz.                   *
 // ******************************************************************************
 function resubmitQuiz() {
  $recordsArray = $_POST;
  
  // Remove the quiz and all associated questions and options from the database.
  $quizID['id'] = $_POST['quizzesID'];
  deleteQuizzes($quizID);
  
  // Add quiz to the database.
  $recordArray['quizzesID'] = addQuizzes($_POST);
  
  // Add questions to the database.
  $questionCounter = 0;
  foreach ($_POST['questions'] as $question)  {
   // for use in options array
   $optionCounter = 0;

   // Correct Option
   $correctOption = $_POST['answers'][$questionCounter];   
   
   // Insert Question
   $rec['quizzesID']   = $recordArray['quizzesID'];
   $rec['question']    = $question;
   $rec['questionsID'] = addQuestions($rec);
   
   // For each option of the current question...
   foreach ($_POST['options'][$questionCounter] as $option) {
    // Determine if option is correct.
    if ($optionCounter != $correctOption)
     $rec['correctOption'] = 0;
    else
     $rec['correctOption'] = 1;
    
    // Add option to the database.
    $rec['option']      = $option;
    addOptions($rec);
        
    // Increment Option Counter
    $optionCounter++;
   }

   // Increment Question Counter
   $questionCounter++;
  }
 }
 
 // ***********************
 // QUESTIONS RECORD      *
 // ***********************
 
 // ******************************************************************************
 // ADD QUESTIONS                                                                *
 // Adds a questions record to the database.                                     *
 // ******************************************************************************
 function addQuestions($record) {
  $question = new Questions(null, $record['quizzesID'], $record['question']);
   
  return $question->add();
 }
 
 // ******************************************************************************
 // UPDATE QUESTIONS                                                             *
 // Update a questions record within the database.                               *
 // ******************************************************************************
 function updateQuestions($record) {
  $question = new Questions($record['id'], $record['quizzesID'], $record['question']);
   
  $question->update();
 }
 
 // ******************************************************************************
 // DELETE QUESTIONS                                                             *
 // Remove a questions record from the database.                                 *
 // ******************************************************************************
 function deleteQuestions($record) { 
  $question = new Questions($record['id'], $record['quizzesID'], $record['question']);
   
  $question->delete();
 }
 
 // ******************************************************************************
 // QUESTIONS ARRAY                                                              *
 // Returns an array containing every record in the questions table.             *
 // ******************************************************************************
 function questionsArray() {
  $str = "
   SELECT id, quizzes_id, question
   FROM questions";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
   
  // Array containing the records to be returned by the function.
  $output = array();

  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']         = $row['id'];
   $output[$x]['quizzesID']  = $row['quizzes_id'];
   $output[$x]['question']   = $row['question'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ******************************************************************************
 // GET QUESTIONS                                                                *
 // Returns an array of associative arrays of Questions Records with             *
 // matching Quizzes ID.                                                         *
 // ******************************************************************************
 function getQuestions($quizzesID) {
  $str = "SELECT id, quizzes_id, question FROM questions WHERE quizzes_id = $quizzesID";
  
  $results = Database::query($str);
  
  $i = 0;
  while($row = mysql_fetch_array($results)){
   $output[$i]['id']        = $row['id'];
   $output[$i]['quizzesID'] = $row['quizzes_id'];
   $output[$i]['question']  = $row['question'];
   $i++;
  }
  
  return $output;
 }
 
 // ***********************
 // OPTIONS RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD OPTIONS                                                                  *
 // Adds an options record to the database.                                      *
 // ******************************************************************************
 function addOptions($record) {
  $option = new Options(NULL, $record['questionsID'], $record['option'], 
   $record['correctOption']);
   
  $option->add();
 }
 
 // ******************************************************************************
 // UPDATE OPTIONS                                                               *
 // Update an options record within the database.                                *
 // ******************************************************************************
 function updateOptions($record) {
  $option = new Options($record['id'], $record['questionsID'], $record['option'], 
   $record['correctOption']);
  
  $option->update();
 }
 
 // ******************************************************************************
 // DELETE OPTIONS                                                               *
 // Remove an options record from the database.                                  *
 // ******************************************************************************
 function deleteOptions($record) { 
  $option = new Options($record['id'], $record['questionsID'], $record['option'], 
   $record['correctOption']);
   
  $option->delete();
 }
 
 // ******************************************************************************
 // OPTIONS ARRAY                                                                *
 // Returns an array containing every record in the options table.               *
 // ******************************************************************************
 function optionsArray() {
  $str = "
   SELECT id, question_id, `option`, correct_option
   FROM options";
   
  // Obtain an array containing each record.
  $records = Database::query($str);
   
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']            = $row['id'];
   $output[$x]['questionsID']    = $row['question_id'];
   $output[$x]['option']        = $row['option'];
   $output[$x]['correctOption'] = $row['correct_option'];
   $x++;
  }
    
  // Return the output array.
  return $output; 
 }
 
 // ******************************************************************************
 // GET OPTIONS                                                                  *
 // Returns an array of associative arrays of Options Records with               *
 // matching Questions ID.                                                       *
 // ******************************************************************************
  function getOptions($questionsID) {
  $str = "
   SELECT id, question_id, `option`, correct_option
   FROM   options 
   WHERE  question_id = $questionsID";
  
  $results = Database::query($str);
  
  $i = 0;
  while($row = mysql_fetch_array($results)){
   $output[$i]['id']            = $row['id'];
   $output[$i]['questionID']    = $row['question_id'];
   $output[$i]['option']        = $row['option'];
   $output[$i]['correctOption'] = $row['correct_option'];
   $i++;
  }
  
  return $output;
 }
 
 // ***********************
 // ATTEMPTS RECORD       *
 // ***********************
 
 // ******************************************************************************
 // ADD ATTEMPTS                                                                 *
 // Adds an attempts record to the database.                                     *
 // ******************************************************************************
 function addAttempts($record) {
  $attempt = new Attempts(NULL, $record['personsID'], $record['quizzesID'], 
   $record['attemptDate'], $record['attemptNumber'], $record['score']);
   
  return $attempt->add();
 }
 
 // ******************************************************************************
 // UPDATE ATTEMPTS                                                              *
 // Update an attempts record within the database.                               *
 // ******************************************************************************
 function updateAttempts($record) {
  $attempt = new Attempts($record['id'], $record['personsID'], $record['quizzesID'], 
   $record['attemptDate'], $record['attemptNumber'], $record['score']);
   
  $attempt->update();
 }
 
 // ******************************************************************************
 // DELETE ATTEMPTS                                                              *
 // Remove an attempts record from the database.                                 *
 // ******************************************************************************
 function deleteAttempts($record) { 
  $attempt = new Attempts($record['id'], $record['personsID'], $record['quizzesID'], 
   $record['attemptDate'], $record['attemptNumber'], $record['score']);
   
  $attempt->delete();
 }
 
 // ******************************************************************************
 // ATTEMPTS ARRAY                                                               *
 // Returns an array containing every record in the attempts table.              *
 // ******************************************************************************
 function attemptsArray() {
  $str = "
   SELECT id, persons_id, quizzes_id, attempt_date, attempt_number, score
   FROM attempts";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
    
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']            = $row['id'];
   $output[$x]['personsID']     = $row['persons_id'];
   $output[$x]['quizzesID']     = $row['quizzes_id'];
   $output[$x]['attemptDate']   = $row['attempt_date'];
   $output[$x]['attemptNumber'] = $row['attempt_number'];
   $output[$x]['score']         = $row['score'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ******************************************************************************
 // SUBMIT ATTEMPT                                                               *
 // Adds the submitted attempt and associated responses to the database.         *
 // ******************************************************************************
 function submitAttempt($record) { 
  // Number of attempts made by the current user.
  $str         = "SELECT id FROM attempts WHERE persons_id = " . $_SESSION['id'];
  $numAttempts = mysql_num_rows(Database::query($str));
  
  // Number of attempts allowed by the quiz.
  $str = "SELECT attempts_allowed FROM quizzes WHERE id = " . $record['quizzesID'];
  $result = mysql_fetch_array(Database::query($str));
  $attemptsAllowed = $result['attempts_allowed'];
  
  // If the user has not exceeded the number of attempts allowed by the quiz...
  if ($numAttempts < $attemptsAllowed) { 
   // Create Attempt
   $rec['personsID']     = $_SESSION['id'];
   $rec['quizzesID']     = $record['quizzesID'];
   $rec['attemptDate']   = date("Y-m-d h:i:sa");
   $rec['attemptNumber'] = ($numAttempts + 1);
   $rec['score']         = 0;
   $rec['attemptsID']    = addAttempts($rec);
   $rec['id']            = $rec['attemptsID'];
  
   $counter = 0;
   foreach ($record['responses'] as $response) {
    // Score Attempt
    $str = "SELECT correct_option FROM options WHERE id = " . $response;
    $option = mysql_fetch_array(Database::query($str));
    if ($option['correct_option'] == 1) $rec['score']++;
   
    // Add Response
    $rec['questionsID'] = $record['questionsID'][$counter];
    $rec['optionsID']   = $response;
    addResponses($rec);
    
    $counter++;
   }
  
   // Update Attempt to reflect score
   updateAttempts($rec);
  }
 }
 
 // ***********************
 // RESPONSES RECORD      *
 // ***********************
 
 // ******************************************************************************
 // ADD RESPONSES                                                                *
 // Adds an responses record to the database.                                    *
 // ******************************************************************************
 function addResponses($record) {
  $response = new Responses(NULL, $record['questionsID'], $record['attemptsID'], 
   $record['optionsID']);
   
  $response->add();
 }
 
 // ******************************************************************************
 // UPDATE RESPONSES                                                             *
 // Update an responses record within the database.                              *
 // ******************************************************************************
 function updateResponses($record) {
  $response = new Responses($record['id'], $record['questionsID'], $record['attemptsID'], 
   $record['optionsID']);
   
  $response->update();
 }
 
 // ******************************************************************************
 // DELETE RESPONSES                                                             *
 // Remove an responses record from the database.                                *
 // ******************************************************************************
 function deleteResponses($record) { 
  $response = new Responses($record['id'], $record['questionsID'], $record['attemptsID'], 
   $record['optionsID']);
   
  $response->delete();
 }
 
 // ******************************************************************************
 // RESPONSES ARRAY
 // Returns an array containing every record in the Responses table.             *
 // ******************************************************************************
 function responsesArray() {
  $str = "
   SELECT id, questions_id, attempts_id, options_id
   FROM responses";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
    
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']          = $row['id'];
   $output[$x]['questionsID'] = $row['questions_id'];
   $output[$x]['attemptsID']  = $row['attempts_id'];
   $output[$x]['optionsID']   = $row['options_id'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ***********************
 // REVIEWS RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD REVIEWS                                                                  *
 // Adds an reviews record to the database.                                      *
 // ******************************************************************************
 function addReviews($record) {
  $review = new Reviews(NULL, $record['personsID'], $record['lessonsID'], 
   $record['title'], $record['review'], $record['dateSubmitted'], $record['rating']);
   
  $review->add();
 }
 
 // ******************************************************************************
 // UPDATE REVIEWS                                                               *
 // Update an reviews record within the database.                                *
 // ******************************************************************************
 function updateReviews($record) {
  $review = new Reviews($record['id'], $record['personsID'], $record['lessonsID'], 
   $record['title'], $record['review'], $record['dateSubmitted'], $record['rating']);
   
  $review->update();
 }
 
 // ******************************************************************************
 // DELETE REVIEWS                                                               *
 // Remove an reviews record from the database.                                  *
 // ******************************************************************************
 function deleteReviews($record) { 
  $review = new Reviews($record['id'], $record['personsID'], $record['lessonsID'], 
   $record['title'], $record['review'], $record['dateSubmitted'], $record['rating']);
   
  $review->delete();
 }
 
 // ******************************************************************************
 // REVIEWS ARRAY
 // Returns an array containing every record in the reviews table.               *
 // ******************************************************************************
 function reviewsArray() {
  $str = "
   SELECT id, persons_id, lessons_id, title, review, date_submitted, rating
   FROM reviews";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
    
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']            = $row['id'];
   $output[$x]['personsID']     = $row['persons_id'];
   $output[$x]['lessonsID']     = $row['lessons_id'];
   $output[$x]['title']         = $row['title'];
   $output[$x]['review']        = $row['review'];
   $output[$x]['dateSubmitted'] = $row['date_submitted'];
   $output[$x]['rating']        = $row['rating'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
 
 // ***********************
 // REPORTS RECORD        *
 // ***********************
 
 // ******************************************************************************
 // ADD REPORTS                                                                  *
 // Adds an reports record to the database.                                      *
 // ******************************************************************************
 function addReports($record) {
  $report = new Reports(NULL, $record['personsID'], $record['name'], $record['query'], 
   $record['dateCreated']);
   
  $report->add();
 }
 
 // ******************************************************************************
 // UPDATE REPORTS                                                               *
 // Update an reports record within the database.                                *
 // ******************************************************************************
 function updateReports($record) {
  $report = new Reports($record['id'], $record['personsID'], $record['name'], 
   $record['query'], $record['dateCreated']);
   
  $report->update();
 }
 
 // ******************************************************************************
 // DELETE REPORTS                                                               *
 // Remove an reports record from the database.                                  *
 // ******************************************************************************
 function deleteReports($record) { 
  $report = new Reports($record['id'], $record['perosnsID'], $record['name'], 
   $record['query'], $record['dateCreated']);
   
  $report->delete();
 }
 
 // ******************************************************************************
 // REPORTS ARRAY
 // Returns an array containing every record in the reports table.               *
 // ******************************************************************************
 function reportsArray() {
  $str = "
   SELECT id, persons_id, reportname, reportquery, date_created
   FROM reports";
    
  // Obtain an array containing each record.
  $records = Database::query($str);
    
  // Array containing the records to be returned by the function.
  $output = array();
    
  // Add each record to the array.
  $x = 0;
  while($row = mysql_fetch_array($records)){
   $output[$x]['id']          = $row['id'];
   $output[$x]['personsID']   = $row['persons_id'];
   $output[$x]['name']        = $row['reportname'];
   $output[$x]['query']       = $row['reportquery'];
   $output[$x]['dateCreated'] = $row['date_created'];
   $x++;
  }
    
  // Return the output array.
  return $output;
 }
?>
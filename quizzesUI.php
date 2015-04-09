<?php
/*
 File Name   : quizzesUI.php
 Date        : 2/18/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Quizzes table.
*/
 // Required Files
 require_once('recordsManager.php');
 require_once('questionsUI.php');
 
 // ******************************************************************************
 // DISPLAY QUIZZES TABLE                                                        *
 // Display a table containing every Quizzes record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayQuizzesTable() {
  // Get an array containing all the quizzes records.
  $records = quizzesArray();
  
  // Used by the administrative buttons within the table.
  echo '
   <!-- function for setting the serialized record -->
   <script>
    function setRecord(rec) {
     document.getElementById("record").value = rec;
    }
   </script>';
   
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
     
  // Opening Tags
  echo "
   <form method='POST' action='$fileName'>
   <table>";
  
  // Hidden field for storing serialized record.
  echo "<input type='hidden' id='record' name ='record'>";
  
  // Add the table headers.
  echo "<tr><th>ID</th><th>Lessons ID</th><th>Attempts Allowed</th><th>" .
   "Title</th><th>Description</th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[lessonsID]</td>
     <td>$record[attemptsAllowed]</td>
     <td>$record[title]</td>
     <td>$record[description]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateQuiz' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteQuiz' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD QUIZ FORM                                                                *
 // Displays a form for adding a quizzes record to the database.                 *
 // - questionForm division allows for the options insertion of question forms.  *
 // - questionButton division allows for the optional insertion of a button for  *
 //   dynamically adding question forms.                                         *
 // ******************************************************************************
 function addQuizForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Lessons ID: </td>
      <td><input type='text' name='lessonsID' id='lessonsID' value='' size='20'></td>
     </tr><tr>
      <td>Attempts Allowed: </td>
      <td><input type='text' name='attemptsAllowed' id='attemptsAllowed' value='' size='30'></td>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='title' id='title' value='' size='30'></td>
     </tr><tr>
      <td>Description: </td>
      <td><input type='text' name='description' id='description' value='' size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addQuiz' id='addQuiz' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE QUIZ FORM                                                             *
 // Displays a form for adding a quizzes record to the database.                 *
 // ******************************************************************************
 function updateQuizForm() {
  addQuizForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value              = \'' . $rec[id]              . '\';
    document.getElementById("lessonsID").value       = \'' . $rec[lessonsID]       . '\';
    document.getElementById("attemptsAllowed").value = \'' . $rec[attemptsAllowed] . '\';
    document.getElementById("title").value           = \'' . $rec[title]           . '\';
    document.getElementById("description").value     = \'' . $rec[description]     . '\';
    // Change the text on the submit button.
    document.getElementById("addQuiz").value         = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE QUIZ FORM                                                             *
 // Handles a delete request by the displayQuizzesTable function.                *
 // ******************************************************************************
 function deleteQuizForm() {
  $rec = unserialize($_POST['record']);
  deleteQuizzes($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
 
 // ******************************************************************************
 // RESUBMIT QUIZ FORM                                                           *
 // This form displays the entirety of a quiz allowing the user to make changes  *
 // to the quiz information, questions, and/or options within. The user can also *
 // add new questions, or remove old ones.                                       *
 // ******************************************************************************
 function resubmitQuizForm($rec) {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
 
  // Dynamically Add Questions Forms
  dynamicQuestionForm();
  
  // Display the Quiz Information
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing quizzes id -->
    <input type='hidden' name='quizzesID' value=" . $rec['id']        . ">
    <input type='hidden' name='lessonsID' value=" . $rec['lessonsID'] . ">
    <table>
     <tr>
      <td><b>QUIZ:</b</td>
     </tr><tr>
      <td>Attempts Allowed: </td>
      <td><input type='text' name='attemptsAllowed' value='" . $rec['attemptsAllowed'] 
       . "' size='30'></td>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='title'           value='" . $rec['title']  
       . "' size='30'></td>
     </tr><tr>
      <td>Description: </td>
      <td><input type='text' name='description'     value='" . $rec['description'] 
       . "' size='30'></td>
     </tr><tr>
      <td><br><b>QUESTIONS:</b></td>
     </tr>
    </table>";
  
  // Display Each Question
  $questions = getQuestions($rec['id']);
  $questionCounter = 0;
  foreach ($questions as $question) {
   // Question Field
   echo "Question " . ($questionCounter + 1) . ": 
    <input type='hidden' name='questionID[]' value='" . $question['id']       . "'>
    <input type='text'   name='questions[]'  value='" . $question['question'] . "'><br>";
   
   // Get Options
   $options = getOptions($question['id']);
   
   // Options Field
   echo "
     A.) <input name='options[" . $questionCounter . "][]' value='" . 
     $options[0]['option'] . "'><br>" .
    "B.) <input name='options[" . $questionCounter . "][]' value='" .
     $options[1]['option'] . "'><br>" .
	"C.) <input name='options[" . $questionCounter . "][]' value='" .
     $options[2]['option'] . "'><br>" .
    "D.) <input name='options[" . $questionCounter . "][]' value='" .
     $options[3]['option'] . "'><br>" .
	"E.) <input name='options[" . $questionCounter . "][]' value='" .
     $options[4]['option'] . "'><br>";
      
   // Answer Field
   echo "</p><p>Correct Answer: <select name = answers[]><option value='0'";
   if ($options[0]['correctOption'] == 1) { echo " selected"; }
   echo ">A</option><option value='1'";
   if ($options[1]['correctOption'] == 1) { echo " selected"; }
   echo ">B</option><option value='2'";
   if ($options[2]['correctOption'] == 1) { echo " selected"; }
   echo ">C</option><option value='3'";
   if ($options[3]['correctOption'] == 1) { echo " selected"; }
   echo ">D</option><option value='4'"; 
   if ($options[4]['correctOption'] == 1) { echo " selected"; }
   echo ">E</option></select><br><br>";
    
   $questionCounter++;
  }
  
  // Update the counter in the dynamic questions form function.
  echo "<script>var counter = " . $questionCounter . ";</script>";
  
  // Division for adding new questions forms.
  echo "<div id='questionForm'></div>";
  
  // Display Buttons
  echo "
    <input value='Add Question' onclick='addQuestion(\"questionForm\");' type='button'>
    <br><input name='submitQuiz' value='Submit' type='submit'>
    <br><input name='cancel'     value='Cancel' type='submit'>";
  
  echo "</form>";
 }
 
 // ******************************************************************************
 // TAKE QUIZ FORM                                                               *
 // Displays a form for taking a quiz.                                           *
 // ******************************************************************************
 function takeQuizForm($lessonsID) {
  // Get Questions
  $quiz      = getQuiz($lessonsID);
  $questions = getQuestions($quiz['id']);
  
  // Hidden Field for Quizzes ID
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  echo "<form method='POST' action='$fileName'>
   <input type='hidden' name='quizzesID' value='$quiz[id]'>";
  
  // Display Each Question
  $questionCounter = 0;
  foreach ($questions as $question) {
   echo "Question " . ($questionCounter + 1) . ": " . $question['question'] . "<br>";
   
   // Hidden Field for Questions ID
   echo "<input type='hidden' name='questionsID[]' value='$question[id]'>";
   
   // Get Options
   $options = getOptions($question['id']);
   
   // Options Field
   echo "
    <input type='radio' name='responses["    . $questionCounter      . 
     "]' value='" . $options[0]['id'] . "'>" . $options[0]['option'] . "<br>
    <input type='radio' name='responses["    . $questionCounter      . 
     "]' value='" . $options[1]['id'] . "'>" . $options[1]['option'] . "<br>
    <input type='radio' name='responses["    . $questionCounter      . 
     "]' value='" . $options[2]['id'] . "'>" . $options[2]['option'] . "<br>
    <input type='radio' name='responses["    . $questionCounter      . 
     "]' value='" . $options[3]['id'] . "'>" . $options[3]['option'] . "<br>
    <input type='radio' name='responses["    . $questionCounter      . 
     "]' value='" . $options[4]['id'] . "'>" . $options[4]['option'] . "<br>";

   $questionCounter++;
  }
  
  // Display Buttons
  echo "
    <input name='submitAttempt' value='Submit' type='submit'><br>
    <input name='cancel'        value='Cancel' type='submit'>";
  
  echo "</form>";
 }
?>
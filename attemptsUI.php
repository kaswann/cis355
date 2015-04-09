<?php
/*
 File Name   : attemptsUI.php
 Date        : 2/18/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Attempts table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY Attempts TABLE                                                       *
 // Display a table containing every Attempts record,                            *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayAttemptsTable() {
  // Get an array containing all the attempts records.
  $records = attemptsArray();
  
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
  echo "<tr><th>ID</th><th>Persons ID</th><th>Quizzes ID</th><th>Attempt Date" .
   "</th><th>Attempt Number</th><th>score</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[personsID]</td>
     <td>$record[quizzesID]</td>
     <td>$record[attemptDate]</td>
     <td>$record[attemptNumber]</td>
     <td>$record[score]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateAttempt' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteAttempt' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD ATTEMPTS FORM                                                            *
 // Displays a form for adding a attempts record to the database.                *
 // ******************************************************************************
 function addAttemptsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Persons ID: </td>
      <td><input type='text' name='personsID' id='personsID' value='' size='20'></td>
     </tr><tr>
      <td>Quizzes ID: </td>
      <td><input type='text' name='quizzesID' id='quizzesID' value='' size='30'></td>
     </tr><tr>
      <td>Attempt Date: </td>
      <td><input type='text' name='attemptDate' id='attemptDate' value='' size='30'></td>
     </tr><tr>
      <td>Attempt Number: </td>
      <td><input type='text' name='attemptNumber' id='attemptNumber' value='' size='30'></td>
     </tr><tr>
      <td>Score: </td>
      <td><input type='text' name='score' id='score' value='' size='20'></td>
     </tr><tr>
      <td><input type='submit' name='addAttempt' id='addAttempt' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE ATTEMPT FORM                                                          *
 // Displays a form for adding a attempts record to the database.                *
 // ******************************************************************************
 function updateAttemptsForm() {
  addAttemptsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value            = \'' . $rec[id]            . '\';
    document.getElementById("personsID").value     = \'' . $rec[personsID]     . '\';
    document.getElementById("quizzesID").value     = \'' . $rec[quizzesID]     . '\';
    document.getElementById("attemptDate").value   = \'' . $rec[attemptDate]   . '\';
    document.getElementById("attemptNumber").value = \'' . $rec[attemptNumber] . '\';
    document.getElementById("score").value         = \'' . $rec[score]         . '\';
    // Change the text on the submit button.
    document.getElementById("addAttempt").value    = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE ATTEMPTS FORM                                                          *
 // Handles a delete request by the displayAttemptsTable function.                *
 // ******************************************************************************
 function deleteAttemptsForm() {
  $rec = unserialize($_POST['record']);
  deleteAttempts($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
 
 // ******************************************************************************
 // VIEW ATTEMPTS                                                                *
 // Display the attempts made on the quiz of the specified lesson.               *
 // ******************************************************************************
 function viewAttempts($lessonsID) {
  // Get an array containing all the attempts records.
  $records = attemptsArray();
  
  // Get the id of the lesson's quiz.
  $quiz   = getQuiz($lessonsID);
  $quizID = $quiz['id'];
  
  // Table Headers
  echo "<table><tr><th> First Name </th><th> Last Name </th><th> Date </th>" .
   "<th> Attempt </th><th> Score </th><th></th></tr>";
  
  foreach ($records as $record) {
   if ($record['quizzesID'] == $quizID) {
    // Get Persons Record
    $person = getPerson($record['personsID']);
    
    // Table Row
    echo "<tr><td>$person[firstName]</td><td>$person[lastName]</td><td>" .
     "$record[attemptDate]</td><td>$record[attemptNumber]</td><td>$record[score]".
     "</td></tr>";
   }
  }

  echo "</table>";
 }
?>
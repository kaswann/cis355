<?php
/*
 File Name   : lessonsUI.php
 Date        : 2/23/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Lessons table.
*/
 // Required Files
 require_once('recordsManager.php');
 require_once('questionsUI.php');
 
 // ******************************************************************************
 // DISPLAY LESSONS TABLE                                                        *
 // Display a table containing every Lessons record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayLessonsTable() {
  // Get an array containing all the lessons records.
  $records = lessonsArray();
  
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
  echo "<tr><th>ID</th><th>Title</th><th>Subject</th><th>Description</th>".
   "<th>Resources</th><th>Persons ID</th><th>Date Created</th><th>Search " .
   "Field</th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[title]</td>
     <td>$record[subject]</td>
     <td>$record[description]</td>
     <td>$record[resources]</td>
     <td>$record[personsID]</td>
     <td>$record[dateCreated]</td>
     <td>$record[searchField]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateLesson' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteLesson' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD LESSONS FORM                                                             *
 // Displays a form for adding a lessons record to the database.                 *
 // ******************************************************************************
 function addLessonsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <!-- Date Created: -->
    <input type='hidden' name='dateCreated' id='dateCreated' value='" .
       date("Y-m-d h:i:sa") . "' size='20'>
    <!-- Persons ID: -->
    <input type='hidden' name='personsID' id='personsID' value='" . $_SESSION['id']
       . "' size='20'>    
    <table>
     <tr>
      <td>Title: </td>
      <td><input type='text' name='title' id='title' value='' size='20'></td>
     </tr><tr>
      <td>Subject: </td>
      <td><input type='text' name='subject' id='subject' value='' size='30'></td>
     </tr><tr>
      <td>Description: </td>
      <td><input type='text' name='description' id='description' value='' size='30'></td>
     </tr><tr>
      <td>Resources: </td>
      <td><input type='text' name='resources' id='resources' value='' size='30'></td>
     </tr><tr>
      <td>Search Field: </td>
      <td><input type='text' name='searchField' id='searchField' value=''	size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addLesson' id='addLesson' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE LESSONS FORM                                                          *
 // Displays a form for adding a lessons record to the database.                 *
 // ******************************************************************************
 function updateLessonsForm() {
  addLessonsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value          = \'' . $rec[id]          . '\';
    document.getElementById("title").value       = \'' . $rec[title]       . '\';
    document.getElementById("subject").value     = \'' . $rec[subject]     . '\';
    document.getElementById("description").value = \'' . $rec[description] . '\';
    document.getElementById("resources").value   = \'' . $rec[resources]   . '\';
    document.getElementById("personsID").value   = \'' . $rec[personsID]   . '\';
    document.getElementById("dateCreated").value = \'' . $rec[dateCreated] . '\';
    document.getElementById("searchField").value = \'' . $rec[searchField] . '\';
    // Change the text on the submit button.
    document.getElementById("addLesson").value   = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE LESSONS FORM                                                          *
 // Handles a delete request by the displayLessonsTable function.                *
 // ******************************************************************************
 function deleteLessonsForm() {
  $rec = unserialize($_POST['record']);
  deleteLessons($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
 
 // ******************************************************************************
 // LIST LESSONS                                                                 *
 // Displays a list of lessons and a button to select a lesson.                  *
 // ******************************************************************************
 function listLessons() {
  // Get an array containing all the lessons records.
  $records = lessonsArray();
  
  // Used by the select button within the table.
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
  echo "<tr><th>Title</th><th>Subject</th><th>Description</th></tr>";
  
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[title]</td>
     <td>$record[subject]</td>
     <td>$record[description]</td>
     <td>
      <!-- buttons for selecting a lesson -->
      <input name='selectLesson' type='submit' value='view'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />";
       
    // These buttons only appear if the current user owns the lesson.
    if ($_SESSION['id'] == $record['personsID'])
     echo "
      <input name='editLesson' type='submit' value='edit' 
       onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteLesson' type='submit' value='delete'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />";
        
    echo "</td></tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // DISPLAY LESSON                                                               *
 // Displays a lesson record passed to it.                                       *
 // ******************************************************************************
 function displayLesson($record) {
  $rec = unserialize($record);
  
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  // Display Lesson Information
  echo "<p><b>" . $rec['title'] . "</b><br><u>" . $rec['subject'] . 
   "</u><br>" . $rec['description'] . "</p>";
  
  // Hidden field that stores the ID of the lesson being displayed.
  echo "<p><form method='POST' action=$fileName>";
  echo "<input type='hidden' name='lessonsID' value='$rec[id]'>";
  
  // Display Action Buttons
  if ($_SESSION['role'] == "Teacher" && $_SESSION['id'] == $rec['personsID']) {
   echo "
    <input type='submit' name='editQuiz'     value='Edit Quiz'     style='width:99px;'><br>
    <input type='submit' name='viewAttempts' value='View Attempts' style='width:99px;'><br>
    <input type='submit' name='viewReviews'  value='View Reviews'  style='width:99px;'>";
  } elseif ($_SESSION['role'] == "Student")
   echo "<input type='submit' name='takeQuiz' value='Take Quiz'>";
  elseif ($_SESSION['role'] == "Peer Reviewer") {
   echo "<input type='submit' name='reviewLesson' value='Review Lesson'>";
  }
  echo "</form></p>";
 }
 
 // ******************************************************************************
 // LESSON ENTRY FORM                                                            *
 // Generates a form for entering a lesson.                                      *
 // ******************************************************************************
 function lessonEntryForm() {  
  echo "
   <form method='POST' action='$fileName'>
    
    <table>
     <tr>
      <td><b>Lesson:</b></td>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='lessonTitle' id='lessonTitle' value='' size='20'></td>
     </tr><tr>
      <td>Subject: </td>
      <td><input type='text' name='subject' id='subject' value='' size='30'></td>
     </tr><tr>
      <td>Description: </td>
      <td><input type='text' name='lessonDescription' id='lessonDescription' value='' size='30'></td>
     </tr><tr>
      <td>Resources: </td>
      <td><input type='text' name='resources' id='resources' value='' size='30'></td>
     </tr><tr>
      <td>Search Field: </td>
      <td><input type='text' name='searchField' id='searchField' value=''	size='30'></td>
     </tr><tr>
      <td><br></td>
     </tr><tr>
      <td><b>Quiz:</b></td>
     </tr><tr>
      <td>Attempts Allowed: </td>
      <td><input type='text' name='attemptsAllowed' id='attemptsAllowed' value='' size='30'></td>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='quizTitle' id='quizTitle' value='' size='30'></td>
     </tr><tr>
      <td>Description: </td>
      <td><input type='text' name='quizDescription' id='quizDescription' value='' size='30'></td>
     </tr><tr>
      <td><br></td>
     </tr><tr>
      <td><b>Questions:</b></td>
     </tr>
    </table>
     
    <div id='questionForm'></div>
    <!-- Display one form when page is first loaded. -->
    <script> addQuestion('questionForm'); </script>
    <!-- Button for appending a new question form. -->
    <input value='Add Question' onclick='addQuestion(\"questionForm\");' type='button'>
    <!-- Submit Button -->
    <br><input name='submit' value='Submit' type='submit'>
    <!-- Cancel Button -->
    <br><input name='cancel' value='Cancel' type='submit'>
   </form>";
 }
?>
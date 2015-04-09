<?php
/*
 File Name   : questionsUI.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Questions table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY QUESTIONS TABLE                                                      *
 // Display a table containing every Questions record,                           *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayQuestionsTable() {
  // Get an array containing all the questions records.
  $records = questionsArray();
  
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
  echo "<tr><th>ID</th><th>Quizzes ID</th><th>Question</th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[quizzesID]</td>
     <td>$record[question]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateQuestion' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteQuestion' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD QUESTIONS FORM                                                           *
 // Displays a form for adding a questions record to the database.               *
 // ******************************************************************************
 function addQuestionsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Quizzes ID: </td>
      <td><input type='text' name='quizzesID' id='quizzesID' value='' size='20'></td>
     </tr><tr>
      <td>Question: </td>
      <td><input type='text' name='question' id='question' value='' size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addQuestion' id='addQuestion' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE QUESTIONS FORM                                                        *
 // Displays a form for adding a questions record to the database.               *
 // ******************************************************************************
 function updateQuestionsForm() {
  addQuestionsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value        = \'' . $rec[id]        . '\';
    document.getElementById("quizzesID").value = \'' . $rec[quizzesID] . '\';
    document.getElementById("question").value  = \'' . $rec[question]  . '\';
    // Change the text on the submit button.
    document.getElementById("addQuestion").value = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE QUESTIONS FORM                                                        *
 // Handles a delete request by the displayQuestionsTable function.              *
 // ******************************************************************************
 function deleteQuestionsForm() {
  $rec = unserialize($_POST['record']);
  deleteQuestions($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
 
 // ******************************************************************************
 // DYNAMIC QUESTION FORM                                                        *
 // Creates a javascript function for dynamically adding more question forms.    *
 // ******************************************************************************
 function dynamicQuestionForm() {
  echo '
   <script>
    // Element that the form will be added to, 
    // and later appended to the page.
    var elm;
  
    // Tracks number of records added.
    var counter = 0;
   
    // Number of options per question.
    var optionsLimit = 5;

    // Size of question and option text fields.
    var questionFieldSize = 30;
    var optionFieldSize   = 30;
   
    // Adds a question form to the page.
    function addQuestion(divID){
     // Element that the form will be added to, 
     // and later appended to the page.
     var elm = document.createElement(\'div\');
    
     // Question Field
     elm.innerHTML = "Question " + (counter + 1) + ": " +
      "<input name = \"questions[]\" size = questionFieldSize><br>";
	
     // Option Field
     for (x = 0; x < optionsLimit; x++) {
	  if (x == 0) elm.innerHTML += "A";
	  if (x == 1) elm.innerHTML += "B";
	  if (x == 2) elm.innerHTML += "C";
	  if (x == 3) elm.innerHTML += "D";
	  if (x == 4) elm.innerHTML += "E";
      elm.innerHTML += ".) <input name = \"options["
       + counter + "][]\" size = optionFieldSize><br>";
     }
	
	 // Answer Field
     var str = "</p><p>Correct Answer: "
	 str += "<select name = answers[]>";
	 str += "<option value = \'0\'>A</option>";
	 str += "<option value = \'1\'>B</option>";
	 str += "<option value = \'2\'>C</option>";
	 str += "<option value = \'3\'>D</option>";
	 str += "<option value = \'4\'>E</option>";
	 str += "</select>";
	 elm.innerHTML += str;
    
	// Increment Counter
	counter++;
	
	// Append elm to the page.
    document.getElementById(divID).appendChild(elm);
   }
  </script>';
 }
?>
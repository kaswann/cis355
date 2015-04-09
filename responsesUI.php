<?php
/*
 File Name   : responsesUI.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Responses table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY RESPONSES TABLE                                                      *
 // Display a table containing every Responses record,                           *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayResponsesTable() {
  // Get an array containing all the responses records.
  $records = responsesArray();
  
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
  echo "<tr><th>ID</th><th>Questions ID</th><th>Attempts ID</th><th>" .
   "Options ID</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[questionsID]</td>
     <td>$record[attemptsID]</td>
     <td>$record[optionsID]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateResponse' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteResponse' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD RESPONSES FORM                                                           *
 // Displays a form for adding a responses record to the database.               *
 // ******************************************************************************
 function addResponsesForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Questions ID: </td>
      <td><input type='text' name='questionsID' id='questionsID' value='' size='20'></td>
     </tr><tr>
      <td>Attempts ID: </td>
      <td><input type='text' name='attemptsID' id='attemptsID' value='' size='30'></td>
     </tr><tr>
      <td>Options ID: </td>
      <td><input type='text' name='optionsID' id='optionsID' value='' size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addResponse' id='addResponse' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE RESPONSES FORM                                                        *
 // Displays a form for adding a responses record to the database.               *
 // ******************************************************************************
 function updateResponsesForm() {
  addResponsesForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value           = \'' . $rec[id]          . '\';
    document.getElementById("questionsID").value  = \'' . $rec[questionsID] . '\';
    document.getElementById("attemptsID").value   = \'' . $rec[attemptsID]  . '\';
    document.getElementById("optionsID").value    = \'' . $rec[optionsID]   . '\';
    // Change the text on the submit button.
    document.getElementById("addResponse").value = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE RESPONSES FORM                                                        *
 // Handles a delete request by the displayResponsesTable function.              *
 // ******************************************************************************
 function deleteResponsesForm() {
  $rec = unserialize($_POST['record']);
  deleteResponses($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
?>

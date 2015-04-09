<?php
/*
 File Name   : optionsUI.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Options table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY OPTIONS TABLE                                                        *
 // Display a table containing every Options record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayOptionsTable() {
  // Get an array containing all the options records.
  $records = optionsArray();
  
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
   <form id='form' method='POST' action='$fileName'><div id='test'></div>
   <table>";
  
  // Hidden field for storing serialized record.
  echo "<input type='hidden' id='record' name ='record'>";
  
  // Add the table headers.
  echo "<tr><th>ID</th><th>Question ID</th><th>Option</th><th>Correct Option" .
   "</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[questionsID]</td>
     <td>$record[option]</td>
     <td>$record[correctOption]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateOption' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteOption' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD OPTIONS FORM                                                             *
 // Displays a form for adding a options record to the database.                 *
 // ******************************************************************************
 function addOptionsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Question ID: </td>
      <td><input type='text' name='questionsID' id='questionsID' value='' size='20'></td>
     </tr><tr>
      <td>Option: </td>
      <td><input type='text' name='option' id='option' value='' size='30'></td>
     </tr><tr>
      <td>Correct Option: </td>
      <td><input type='text' name='correctOption' id='correctOption' value='' size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addOption' id='addOption' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE OPTIONS FORM                                                          *
 // Displays a form for adding a options record to the database.                 *
 // ******************************************************************************
 function updateOptionsForm() {
  addOptionsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value            = \'' . $rec[id]            . '\';
    document.getElementById("questionsID").value    = \'' . $rec[questionsID]    . '\';
    document.getElementById("option").value        = \'' . $rec[option]        . '\';
    document.getElementById("correctOption").value = \'' . $rec[correctOption] . '\';
    // Change the text on the submit button.
    document.getElementById("addOption").value     = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE OPTIONS FORM                                                          *
 // Handles a delete request by the displayOptionsTable function.                *
 // ******************************************************************************
 function deleteOptionsForm() {
  $rec = unserialize($_POST['record']);
  deleteOptions($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
?>
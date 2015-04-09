<?php
/*
 File Name   : reportsUI.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Reports table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY REPORTS TABLE                                                        *
 // Display a table containing every Reports record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayReportsTable() {
  // Get an array containing all the reports records.
  $records = reportsArray();
  
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
  echo "<tr><th>ID</th><th>Name</th><th>Query</th><th>Persons ID</th><th>" .
   "Date Created</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[name]</td>
     <td>$record[query]</td>
     <td>$record[personsID]</td>
     <td>$record[dateCreated]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateReport' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteReport' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD REPORTS FORM                                                             *
 // Displays a form for adding a reports record to the database.                 *
 // ******************************************************************************
 function addReportsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Name: </td>
      <td><input type='text' name='name' id='name' value='' size='20'></td>
     </tr><tr>
      <td>Query: </td>
      <td><input type='text' name='query' id='query' value='' size='30'></td>
     </tr><tr>
      <td>Persons ID: </td>
      <td><input type='text' name='personsID' id='personsID' value='' size='30'></td>
     </tr><tr>
      <td>Date Created: </td>
      <td><input type='text' name='dateCreated' id='dateCreated' value='' size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addReport' id='addReport' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE REPORTS FORM                                                          *
 // Displays a form for adding a reports record to the database.                 *
 // ******************************************************************************
 function updateReportsForm() {
  addReportsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value          = \'' . $rec[id]          . '\';
    document.getElementById("name").value        = \'' . $rec[name]        . '\';
    document.getElementById("query").value       = \'' . $rec[query]       . '\';
    document.getElementById("personsID").value   = \'' . $rec[personsID]   . '\';
    document.getElementById("dateCreated").value = \'' . $rec[dateCreated] . '\';
    // Change the text on the submit button.
    document.getElementById("addReport").value   = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE REPORTS FORM                                                          *
 // Handles a delete request by the displayReportsTable function.                *
 // ******************************************************************************
 function deleteReportsForm() {
  $rec = unserialize($_POST['record']);
  deleteReports($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
?>
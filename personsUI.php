<?php
/*
 File Name   : personsUI.php
 Date        : 2/18/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Persons table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY PERSONS TABLE                                                        *
 // Display a table containing every Persons record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayPersonsTable() {
  // Get an array containing all the persons records.
  $records = personsArray();
  
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
  echo "<tr><th>ID</th><th>Role</th><th>Secondary Role</th><th>" .
   "First Name</th><th>Last Name</th><th>email</th><th>Password Hash". 
   "</th><th>School</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[role]</td>
     <td>$record[secondaryRole]</td>
     <td>$record[firstName]</td>
     <td>$record[lastName]</td>
     <td>$record[email]</td>
     <td>$record[passwordHash]</td>
     <td>$record[school]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updatePerson' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deletePerson' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD PERSONS FORM                                                             *
 // Displays a form for adding a persons record to the database.                 *
 // ******************************************************************************
 function addPersonsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>Role: </td>
      <td><select name='role'><option value=1>Teacher</option><option value=2>
       Student</option><option value=3>Peer Reviewer</option></td>
     </tr><tr>
      <td>Seconday Role: </td>
      <td><select name='secondaryRole'><option value=1>Teacher</option><option value=2>
       Student</option><option value=3>Peer Reviewer</option></td>
     </tr><tr>
      <td>First Name: </td>
      <td><input type='text' name='firstName' id='firstName' value='' size='30'></td>
     </tr><tr>
      <td>Last Name: </td>
      <td><input type='text' name='lastName' id='lastName' value='' size='30'></td>
     </tr><tr>
      <td>Email: </td>
      <td><input type='text' name='email' id='email' value='' size='20'></td>
     </tr><tr>
      <td>Password: </td>
      <td><input type='text' name='password' id='password' value='' size='20'></td>
     </tr><tr>
      <td>School: </td>
      <td><input type='text' name='school' id='school' value=''	size='30'></td>
     </tr><tr>
      <td><input type='submit' name='addPerson' id='addPerson' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE PERSONS FORM                                                          *
 // Displays a form for adding a persons record to the database.                 *
 // ******************************************************************************
 function updatePeronsForm() {
  addPersonsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value            = \'' . $rec[id]            . '\';
    document.getElementById("role").value          = \'' . $rec[role]          . '\';
    document.getElementById("secondaryRole").value = \'' . $rec[secondaryRole] . '\';
    document.getElementById("firstName").value     = \'' . $rec[firstName]     . '\';
    document.getElementById("lastName").value      = \'' . $rec[lastName]      . '\';
    document.getElementById("email").value         = \'' . $rec[email]         . '\';
    document.getElementById("password").value      = \'' . $rec[passwordHash]  . '\';
    document.getElementById("school").value        = \'' . $rec[school]        . '\';
    // Change the text on the submit button.
    document.getElementById("addPerson").value     = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE PERSONS FORM                                                          *
 // Handles a delete request by the displayPersonsTable function.                *
 // ******************************************************************************
 function deletePersonsForm() {
  $rec = unserialize($_POST['record']);
  deletePersons($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
?>

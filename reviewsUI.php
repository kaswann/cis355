<?php
/*
 File Name   : reviewsUI.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  User Interface functions related to the Reviews table.
*/
 // Required Files
 require_once('recordsManager.php');
 
 // ******************************************************************************
 // DISPLAY REVIEWS TABLE                                                        *
 // Display a table containing every Reviews record,                             *
 // and options for administrative actions.                                      *
 // ******************************************************************************
 function displayReviewsTable() {
  // Get an array containing all the reviews records.
  $records = reviewsArray();
  
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
  echo "<tr><th>ID</th><th>Persons ID</th><th>Lessons ID</th><th>Title</th><th>" . 
   "Review</th><th>Date Submitted</th><th>Rating</th><th></th></tr>";
   
  // Display each row.
  foreach ($records as $record) {
   $serializedRecord = addslashes(serialize($record));
   echo "
    <tr>
     <td>$record[id]</td>
     <td>$record[personsID]</td>
     <td>$record[lessonsID]</td>
     <td>$record[title]</td>
     <td>$record[review]</td>
     <td>$record[dateSubmitted]</td>
     <td>$record[rating]</td>
     <td>
      <!-- buttons for adminstrative actions -->
      <input name='updateReview' type='submit' value='update'
	   onclick='setRecord(\"" . $serializedRecord . "\")' />
      <input name='deleteReview' type='submit' value='delete'
       onclick='setRecord(\"" . $serializedRecord . "\")'>
     </td>
    </tr>";
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ******************************************************************************
 // ADD REVIEWS FORM                                                             *
 // Displays a form for adding a reviews record to the database.                 *
 // ******************************************************************************
 function addReviewsForm() {
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
      <td>Lessons ID: </td>
      <td><input type='text' name='lessonsID' id='lessonsID' value='' size='30'></td>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='title' id='title' value='' size='30'></td>
     </tr><tr>
      <td>Review: </td>
      <td><input type='text' name='review' id='review' value='' size='30'></td>
     </tr><tr>
      <td>Date Submitted: </td>
      <td><input type='text' name='dateSubmitted' id='dateSubmitted' value='' size='20'></td>
     </tr><tr>
      <td>Rating: </td>
      <td><input type='text' name='rating' id='rating' value='' size='20'></td>
     </tr><tr>
      <td><input type='submit' name='addReview' id='addReview' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // UPDATE REVIEWS FORM                                                          *
 // Displays a form for adding a reviews record to the database.                 *
 // ******************************************************************************
 function updateReviewsForm() {
  addReviewsForm();
  $rec = unserialize($_POST['record']);
  echo '
   <script>
    document.getElementById("id").value            = \'' . $rec[id]            . '\';
    document.getElementById("personsID").value     = \'' . $rec[personsID]     . '\';
    document.getElementById("lessonsID").value     = \'' . $rec[lessonsID]     . '\';
    document.getElementById("title").value         = \'' . $rec[title]         . '\';
    document.getElementById("review").value        = \'' . $rec[review]        . '\';
    document.getElementById("dateSubmitted").value = \'' . $rec[dateSubmitted] . '\';
    document.getElementById("rating").value        = \'' . $rec[rating]        . '\';
    // Change the text on the submit button.
    document.getElementById("addReview").value     = "Update Record";
   </script>';
 }
 
 // ******************************************************************************
 // DELETE REVIEWS FORM                                                          *
 // Handles a delete request by the displayReviewsTable function.                *
 // ******************************************************************************
 function deleteReviewsForm() {
  $rec = unserialize($_POST['record']);
  deleteReviews($rec);
  
  // Redirect back to the calling page.
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  header('Location: ' .  $fileName);
 }
 
 // ******************************************************************************
 // SUBMIT REVIEW FORM                                                           *
 // Displays a form for submitting a review.                                     *
 // ******************************************************************************
 function submitReviewForm($lessonsID) {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <input type='hidden' name='personsID'     value='" . $_SESSION[id]        . "'>
    <input type='hidden' name='lessonsID'     value='" . $lessonsID           . "'>
    <input type='hidden' name='dateSubmitted' value='" . date("Y-m-d h:i:sa") . "'>
    <input type='hidden' name='' value='$lessonsID   '>
    <table>
     </tr><tr>
      <td>Title: </td>
      <td><input type='text' name='title' value='' size='30'></td>
     </tr><tr>
      <td>Review: </td>
      <td><textarea name='review' cols='30' rows='4'></textarea></td>
     </tr><tr>
      <td>Rating: </td>
      <td><select name='rating'><option value=1>1</option><option value=2>2</option>
       <option value=3>3</option><option value=4>4</option><option value=5>5</option></td>
     </tr><tr>
      <td><input type='submit' name='submitReview' value='Submit'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ******************************************************************************
 // VIEW REVIEWS                                                                 *
 // Displays a list of reviews for a specified lesson.                           *
 // ******************************************************************************
 function viewReviews($lessonsID) {
  // Get an array containing all the reviews records.
  $records = reviewsArray();
    
  // Table Headers
  echo "<table><tr><th> First Name </th><th> Last Name </th><th> Date </th>" .
   "<th> Rating </th><th> Review </th><th></th></tr>";
  
  foreach ($records as $record) {
   if ($record['lessonsID'] == $lessonsID) {
    // Get Persons Record
    $person = getPerson($record['personsID']);
    
    // Table Row
    echo "<tr><td>$person[firstName]</td><td>$person[lastName]</td><td>" .
     "$record[dateSubmitted]</td><td>$record[rating]</td><td>$record[review]".
     "</td></tr>";
   }
  }

  echo "</table>";
 }
?>

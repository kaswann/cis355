<?php
/*
 File Name   : Responses.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Responses record.
*/
 // Required Files
 require_once('Database.php');
 
 class Responses {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $questionsID;
  private $attemptsID;
  private $optionsID;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $questionsID, $attemptsID, $optionsID) {
   // Set all the parameters.
   $this->id          = $id;
   $this->questionsID = $questionsID;
   $this->attemptsID  = $attemptsID;
   $this->optionsID   = $optionsID;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()          { return $this->id;          }
  public function getQuestionsID() { return $this->questionsID; }
  public function getAttemptsID()  { return $this->attemptsID;  }
  public function getOptionsID()   { return $this->optionsID;   }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO responses (questions_id, attempts_id, options_id)
    VALUES (?,?,?)");
   
   $stmt->bind_param('iii', $this->questionsID, $this->attemptsID, $this->optionsID);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE responses FROM responses WHERE id = ?");
   
   $stmt->bind_param('i', $this->id);
   
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // UPDATE - Update this record in the database.                                 *
  // ******************************************************************************
  public function update() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE responses
    SET questions_id = ?, attempts_id = ?, options_id = ?
    WHERE id = ?");
    
   $stmt->bind_param('iiii', $this->questionsID, $this->attemptsID, $this->optionsID, 
    $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // toArray - Returns an array containing every record in the Responses table.   *
  // ******************************************************************************
  public static function toArray() {
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
 }
?>
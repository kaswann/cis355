<?php
/*
 File Name   : Attempts.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Attempts record.
*/
 // Required Files
 require_once('Database.php');
 
 class Attempts {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $personsID;
  private $quizzesID;
  private $attemptDate;
  private $attemptNumber;
  private $score;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $personsID, $quizzesID, $attemptDate,
   $attemptNumber, $score, $passwordHash, $school) {
   // Set all the parameters.
   $this->id            = $id;
   $this->personsID     = $personsID;
   $this->quizzesID     = $quizzesID;
   $this->attemptDate   = $attemptDate;
   $this->attemptNumber = $attemptNumber;
   $this->score         = $score;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()            { return $this->id;            }
  public function getPersonsID()     { return $this->personsID;     }
  public function getQuizzesID()     { return $this->quizzesID;     }
  public function getAttemptDate()   { return $this->attemptDate;   }
  public function getAttemptNumber() { return $this->attemptNumber; }
  public function getScore()         { return $this->score;         }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO attempts (persons_id, quizzes_id, attempt_date, attempt_number, score)
    VALUES (?,?,?,?,?)");
   
   $stmt->bind_param('iisii', $this->personsID, $this->quizzesID, $this->attemptDate, 
    $this->attemptNumber, $this->score);
    
   $stmt->execute();
   $stmt->close();
   $insertID = $mysqli->insert_id;
   $mysqli->close();
   
   // Return ID of inserted record.
   return $insertID;
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE attempts FROM attempts WHERE id = ?");
   
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
    UPDATE attempts
    SET persons_id = ?, quizzes_id = ?, attempt_date = ?, attempt_number = ?, score = ?
    WHERE id = ?");
    
   $stmt->bind_param('iisiii', $this->personsID, $this->quizzesID, $this->attemptDate, 
    $this->attemptNumber, $this->score, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>
<?php
/*
 File Name   : Quizzes.php
 Date        : 2/23/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Quizzes record.
*/
 // Required Files
 require_once('Database.php');
 
 class Quizzes {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $lessonsID;
  private $attemptsAllowed;
  private $title;
  private $description;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $lessonsID, $attemptsAllowed, $title, $description) {
   // Set all the parameters.
   $this->id              = $id;
   $this->lessonsID       = $lessonsID;
   $this->attemptsAllowed = $attemptsAllowed;
   $this->title           = $title;
   $this->description     = $description;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()              { return $this->id;              }
  public function getLessonsID()       { return $this->lessonsID;       }
  public function getAttemptsAllowed() { return $this->attemptsAllowed; }
  public function getTitle()           { return $this->title;           }
  public function getDescription()     { return $this->description;     }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO quizzes (lessons_id, attempts_allowed, title, description)
    VALUES (?,?,?,?)");
   
   $stmt->bind_param('iiss', $this->lessonsID, $this->attemptsAllowed,
    $this->title, $this->description);
    
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
   
   $stmt = $mysqli->prepare("DELETE quizzes FROM quizzes WHERE id = ?");
   
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
    UPDATE quizzes
    SET lessons_id = ?, attempts_allowed = ?, title = ?, description = ?
    WHERE id = ?");
    
   $stmt->bind_param('iissi', $this->lessonsID, $this->attemptsAllowed,
    $this->title, $this->description, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>

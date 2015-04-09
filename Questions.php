<?php
/*
 File Name   : Questions.php
 Date        : 2/23/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Questions record.
*/
 // Required Files
 require_once('Database.php');
 
 class Questions {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $quizzesID;
  private $question;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $quizzesID, $question) {
   // Set all the parameters.
   $this->id        = $id;
   $this->quizzesID = $quizzesID;
   $this->question  = $question;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()        { return $this->id;        }
  public function getQuizzesID() { return $this->quizzesID; }
  public function getQuestion()  { return $this->question;  }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO questions (quizzes_id, question)
    VALUES (?,?)");
   
   $stmt->bind_param('is', $this->quizzesID, $this->question);
    
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
   
   $stmt = $mysqli->prepare("DELETE questions FROM questions WHERE id = ?");
   
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
    UPDATE questions
    SET quizzes_id = ?, question = ?
    WHERE id = ?");
    
   $stmt->bind_param('isi', $this->quizzesID, $this->question, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>
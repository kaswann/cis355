<?php
/*
 File Name   : Options.php
 Date        : 2/23/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Options record.
*/
 // Required Files
 require_once('Database.php');
 
 class Options {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $questionsID;
  private $option;
  private $correctOption;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $questionsID, $option, $correctOption) {
   // Set all the parameters.
   $this->id            = $id;
   $this->questionsID   = $questionsID;
   $this->option        = $option;
   $this->correctOption = $correctOption;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()            { return $this->id;            }
  public function getQuestionsID()   { return $this->questionsID;   }
  public function getOption()        { return $this->option;        }
  public function getCorrectOption() { return $this->correctOption; }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO options (question_id, `option`, correct_option)
    VALUES (?,?,?)");
   
   $stmt->bind_param('isi', $this->questionsID, $this->option, $this->correctOption);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE options FROM options WHERE id = ?");
   
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
    UPDATE options
    SET question_id = ?, `option` = ?, correct_option = ?
    WHERE id = ?");

   $stmt->bind_param('isii', $this->questionsID, $this->option, $this->correctOption,
    $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
   
   echo mysql_error();
  }
 }
?>
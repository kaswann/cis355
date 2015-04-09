<?php
/*
 File Name   : Reviews.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Reviews record.
*/
 // Required Files
 require_once('Database.php');
 
 class Reviews {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $personsID;
  private $lessonsID;
  private $title;
  private $review;
  private $dateSubmitted;
  private $rating;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $personsID, $lessonsID, $title, $review, 
   $dateSubmitted, $rating) {
   // Set all the parameters.
   $this->id            = $id;
   $this->personsID     = $personsID;
   $this->lessonsID     = $lessonsID;
   $this->title         = $title;
   $this->review        = $review;
   $this->dateSubmitted = $dateSubmitted;
   $this->rating        = $rating;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()         { return $this->id;            }
  public function getPersonsID()  { return $this->personsID;     }
  public function lessonsID()     { return $this->lessonsID;     }
  public function title()         { return $this->title;         }
  public function review()        { return $this->review;        }
  public function dateSubmitted() { return $this->dateSubmitted; }
  public function rating()        { return $this->rating;        }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO reviews (persons_id, lessons_id, title, review, date_submitted, rating)
    VALUES (?,?,?,?,?,?)");
   
   $stmt->bind_param('iisssi', $this->personsID, $this->lessonsID, $this->title, 
    $this->review, $this->dateSubmitted, $this->rating);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE reviews FROM reviews WHERE id = ?");
   
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
    UPDATE reviews
    SET persons_id = ?, lessons_id = ?, title = ?, review = ?, date_submitted = ?, 
     rating = ?
    WHERE id = ?");
    
   $stmt->bind_param('iisssii', $this->personsID, $this->lessonsID, $this->title, 
    $this->review, $this->dateSubmitted, $this->rating, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>

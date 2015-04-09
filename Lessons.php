<?php
/*
 File Name:  Lessons.php
 Date:       2/23/2015
 Project:    Teacheratti
 Group:      Topaz
 Description: 
  Defines an individual Lessons record.
*/
 // Required Files
 require_once('Database.php');

 class Lessons {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $personsID;
  private $title;
  private $subject;
  private $description;
  private $resources;
  private $dateCreated;
  private $searchField;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $personsID, $title, $subject, $description,
   $resources, $dateCreated, $searchField) {
   $this->id          = $id;
   $this->personsID   = $personsID;
   $this->title       = $title;
   $this->subject     = $subject;
   $this->description = $description;
   $this->resources   = $resources;   
   $this->dateCreated = $dateCreated;
   $this->searchField = $searchField;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()          { return $this->id;          }
  public function getPersonsID()   { return $this->personsID;   }
  public function getTitle()       { return $this->title;       }
  public function getSubject()     { return $this->subject;     }
  public function getDescription() { return $this->description; }
  public function getResources()   { return $this->resources;   }
  public function getDateCreated() { return $this->dateCreated; }
  public function getSearchField() { return $this->searchField; }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO lessons (title, subject, description, resources, persons_ID, 
     date_created, search_field)
    VALUES (?,?,?,?,?,?,?)");
   
   $stmt->bind_param('ssssiss', $this->title, $this->subject, $this->description, 
    $this->resources, $this->personsID, $this->dateCreated, $this->searchField);
    
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
   
   $stmt = $mysqli->prepare("DELETE lessons FROM lessons WHERE id = ?");

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
    UPDATE lessons
    SET title = ?, subject = ?, description = ?, resources = ?, persons_ID = ?, 
     date_created = ?, search_field = ?
    WHERE id = ?");
    
   $stmt->bind_param('ssssissi', $this->title, $this->subject, $this->description, 
    $this->resources, $this->personsID, $this->dateCreated, $this->searchField, 
    $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>
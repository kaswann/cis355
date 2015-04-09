<?php
/*
 File Name   : Reports.php
 Date        : 2/25/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Reports record.
*/
 // Required Files
 require_once('Database.php');
 
 class Reports {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $personsID;
  private $name;
  private $query;  
  private $dateCreated;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $personsID, $name, $query, $dateCreated) {
   // Set all the parameters.
   $this->id          = $id;
   $this->personsID   = $personsID;
   $this->name        = $name;
   $this->query       = $query;
   $this->dateCreated = $dateCreated;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()          { return $this->id;          }
  public function getPersonsID()   { return $this->personsID;   }
  public function getName()        { return $this->name;        }
  public function getQuery()       { return $this->query;       }
  public function getDateCreated() { return $this->dateCreated; }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO reports (persons_id, reportname, reportquery, date_created)
    VALUES (?,?,?,?)");
   
   $stmt->bind_param('isss', $this->personsID, $this->name, $this->query, 
    $this->dateCreated);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE reports FROM reports WHERE id = ?");
   
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
    UPDATE reports
    SET persons_id = ?, reportname = ?, reportquery = ?, date_created = ?
    WHERE id = ?");
    
   $stmt->bind_param('isssi', $this->personsID, $this->name, $this->query, 
    $this->dateCreated, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>

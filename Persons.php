<?php
/*
 File Name   : Persons.php
 Date        : 2/15/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  Defines an individual Persons record.
*/
 // Required Files
 require_once('Database.php');
 
 class Persons {
  // ***********************
  // Data Members          *
  // ***********************
  private $id;
  private $role;
  private $secondaryRole;
  private $firstName;
  private $lastName;
  private $email;
  private $passwordHash;
  private $school;
  
  // ***********************
  // Constructor           *
  // ***********************
  function __construct($id, $role, $secondaryRole, $firstName,
   $lastName, $email, $passwordHash, $school) {
   // Set all the parameters.
   $this->id             = $id;
   $this->role           = $role;
   $this->secondaryRole  = $secondaryRole;
   $this->firstName      = $firstName;
   $this->lastName       = $lastName;
   $this->email          = $email;
   $this->passwordHash   = $passwordHash;
   $this->school         = $school;
  }
  
  // ***********************
  // GET FUNCTIONS         *
  // ***********************
  public function getID()            { return $this->id;            }
  public function getRole()          { return $this->role;          }
  public function getSecondaryRole() { return $this->secondaryRole; }
  public function getFirstName()     { return $this->firstName;     }
  public function getLastName()      { return $this->lastName;      }
  public function getEmail()         { return $this->email;         }
  public function getPasswordHash()  { return $this->passwordHash;  }
  public function getSchool()        { return $this->school;        }
  
  // ***********************
  // DATABASE MANAGEMENT   *
  // ***********************
  
  // ******************************************************************************
  // ADD - Add this record to the database.                                       *
  // ******************************************************************************
  public function add() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO persons (role, secondary_role, first_name, last_name, email, 
     password_hash, school)
    VALUES (?,?,?,?,?,?,?)");
   
   $stmt->bind_param('iisssss', $this->role, $this->secondaryRole, $this->firstName, 
    $this->lastName, $this->email, $this->passwordHash, $this->school);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ******************************************************************************
  // DELETE - Delete this record from the database.                               *
  // ******************************************************************************
  public function delete() {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE persons FROM persons WHERE id = ?");
   
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
    UPDATE persons
    SET role = ?, secondary_role = ?, first_name = ?, last_name = ?, 
     email = ?, password_hash = ?, school = ?
    WHERE id = ?");
    
   $stmt->bind_param('iisssssi', $this->role, $this->secondaryRole, $this->firstName, 
    $this->lastName, $this->email, $this->passwordHash, $this->school, $this->id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>

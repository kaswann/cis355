<?php
/*
 File Name   : Database.php
 Date        : 2/15/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz 
 Description : 
  Static class used for querying the database.
*/
 class Database {
  // ***********************
  // Data Members          *
  // ***********************
  private static $database = "CIS355kaswann";
  private static $server   = "localhost";
  private static $username = "CIS355kaswann";
  private static $password = "impossible";
  
  // ***********************
  // Database Connection   *
  // ***********************
  private static $connection;
  
  // ****************************************
  // CONNECT                                *
  // Connect to the database.               *
  // ****************************************
  private static function connect() {
   // Connect to the database.
   self::$connection = mysql_connect(self::$server, self::$username, self::$password)
    or die ("Connection Error: ".mysql_error());
   
   // Select the database.
   mysql_select_db(self::$database) 
    or die ("Error selecting DB: ".mysql_error());
  }
  
  // ****************************************
  // DISCONNECT                             *
  // Close the database connection.         *
  // ****************************************
  private static function disconnect() {
   mysql_close(self::$connection);
  }
  
  // ****************************************
  // GET MYSQLI                             *
  // ****************************************
  public static function getMYSQLI() {
   $mysqli = new mysqli(self::$server, self::$username, self::$password, 
    self::$database);

   // check connection
   if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   
   return $mysqli;
  }
  
  // ****************************************
  // QUERY                                  *
  // Send a query to the database and       *
  // returns the results to the caller.     *
  // ****************************************
  public static function query($str) {
   // Connect to the database.
   self::connect();
   
   // Obtain query result.
   $output = mysql_query($str);
   
   // Close the database connection
   self::disconnect();
   
   // Return query result.
   return $output;
  }
 }
?>
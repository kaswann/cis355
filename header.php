<?php
/*
 File Name   : header.php
 Date        : 2/21/2015
 Project     : Teacheratti
 Author      : Adam Lee Pero
 Group       : Topaz
 Description : 
  - Contains functions that are meant to be called at the top of every user interface
   file.
  - UI Files requiring the header file do not need to start a new session. The header
   file will start the session if one has not already been started.
  - If a UI Files wants to include the logo of the website, but not want the
   functionality of the addHeader function, they may call the displayLogoOnly function.
  - If a UI File wants to require that the person have an active session in order to 
   view the page, they may call the requireSession function. This file will redirect
   the user to the login page if they do not have an active session.
*/
 // Required Files
 require_once('sessionManager.php');
 
 // Session Start
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();

 // ************************************************************************
 // DISPLAY LOGO ONLY                                                      *
 // This function is meant for pages that wish to display the sites logo   *
 // but not implement the rest of the header file.                         *
 // ************************************************************************
 function displayLogoOnly() {
  // NOT YET IMPLEMENTED
 }
 
 // ************************************************************************ 
 // ADD HEADER                                                             *
 // Defines common functionality for every UI File.                        *
 // - Displays a welcome message to logged in users.                       *
 // - Generates a link that allows the user to log out of the website      *
 //  from the page they are currently on.                                  *
 // ************************************************************************
 function addHeader() {  
  // Display the sites logo.
  displayLogoOnly();
  
  // If the user clicked the logout link included in the header...
  if (isset($_GET['action']) AND $_GET['action'] == 'logout') {
   // call the logout function from the session manager,
   logout();
   
   // and redirect to the login page.
   header('Location: ' . 'login.php');
   
  // If the user is currently logged in...
  } elseif (isset($_SESSION['email'])) {
   // display a welcome message.  
   echo "<div align='right'>Welcome, " . $_SESSION[firstName] . " " . 
    $_SESSION[lastName] . "." . " (<a href=\"" . $fileName . 
    "?action=logout\">logout</a>)</div>";
    
  // If the user is not currently logged in...
  } else {
   // ask the user to log in.
   echo "<div align='right'>Welcome! " . "(<a href=\"login.php\">login</a>" .
    " | <a href=\"register.php\">register</a>)</div>";
  }
  
  // ************************************************************************
  // REQUIRE SESSION                                                        *
  // Redirects the user to the login page if they do not have               *
  // an active session.                                                     *
  // ************************************************************************
  function requireSession() {
   if (!isset($_SESSION['email']))
    header('Location: ' . 'login.php');
  }
 }
?>
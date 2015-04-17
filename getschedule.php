<?php

# example: how to populate a database table from a JSON object

# get data from SVSU API
# $json = file_get_contents('https://api.svsu.edu/courses?prefix=CIS&courseNumber=355');
$json = file_get_contents('https://api.svsu.edu/courses?prefix=CIS');
$json2 = file_get_contents('https://api.svsu.edu/courses?prefix=CS');
# echo $json;

# convert JSON to PHP variable
$obj = json_decode($json);
$obj2 = json_decode($json2);
# print_r($obj);
# var_dump($obj);

# print each course listing 
foreach ( $obj->courses as $course ) {
  # print each course listing (prefix, courseNumber, prerequisites)
  echo $course->prefix . " " . $course->courseNumber . 
    "... REQ: " . $course->prerequisites. $course->term . "-";
    
    # print each course listing (days, startTime)
    foreach($course->meetingTimes as $mtimes)
      echo $mtimes->days. "-". $mtimes->startTime.  " \n";
}
foreach ( $obj2->courses as $course ) {
  # print each course listing (prefix, courseNumber, prerequisites)
  echo $course->prefix . " " . $course->courseNumber . 
    "... REQ: " . $course->prerequisites. $course->term . "-";
    
    # print each course listing (days, startTime)
    foreach($course->meetingTimes as $mtimes)
      echo $mtimes->days. "-". $mtimes->startTime.  " \n";
}
# connect to database 
# https://docs.c9.io/v1.0/docs/setting-up-mysql
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;

    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
    echo "Connected successfully (".$db->host_info.") \n";

# delete all records in table
$usertable = "cp";
$query = "DELETE FROM $database.$usertable WHERE 1>0";
$result = mysqli_query($db,$query);

# populate course-prereq database table with all CS and CIS courses
foreach ( $obj->courses as $course ) {
  $term = $course->term;
  $prereq = $course->prerequisites;
  if(substr($course->prerequisites,0,2) == "CS") $prereq = substr($prereq,0,6);
  else if(substr($course->prerequisites,0,3) == "CIS") $prereq = substr($prereq,0,7);
  else if(substr($course->prerequisites,0,4) == "MATH") $prereq = substr($prereq,0,8);
  else $prereq = "";
  $course = $course->prefix . " " . $course->courseNumber;
  $query = "INSERT INTO $database.$usertable (`id`, `course`, `prereq`, `term`) 
    VALUES (NULL, '$course', '$prereq', '$term')";
  $result = mysqli_query($db, $query);
}
foreach ( $obj2->courses as $course ) {
  $term = $course->term;
  $prereq = $course->prerequisites;
  if(substr($course->prerequisites,0,2) == "CS") $prereq = substr($prereq,0,6);
  else if(substr($course->prerequisites,0,3) == "CIS") $prereq = substr($prereq,0,7);
  else if(substr($course->prerequisites,0,4) == "MATH") $prereq = substr($prereq,0,8);
  else $prereq = "";
  $course = $course->prefix . " " . $course->courseNumber;
  $query = "INSERT INTO $database.$usertable (`id`, `course`, `prereq`, `term`) 
    VALUES (NULL, '$course', '$prereq', '$term')";
  $result = mysqli_query($db, $query);
}

# print first prereq of each course (ignore special cases, multiple prereqs)
$query = "SELECT * FROM cp";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['id'] . ", " . $row['course']. ", ". 
      $row['prereq'] . ", " . $row['term'] . "\n";
}

# to check db contents using command line, type: 
#   mysql-ctl cli
#   use c9;
#   select * from cp;
#   exit

?>
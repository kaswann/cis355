<?php

session_set_cookie_params("session.cookie_domain", "csis.svsu.edu/");
session_start();

// Step 0: ----- Set variables from HTML form 
$id = $_POST["tableId"];
$name = $_POST["name"];
$email = $_POST["email"];
$radio = $_POST["tableMethod"];

// Step 1: ----- Connect to database -----
$hostname="localhost"; //always will be used for host
$username="CIS355kaswann"; //Your username for MySQL
$password="impossible"; //your password for My SQL
$dbname="CIS355kaswann"; //Your username for my SQL
$usertable="table01"; //NAme of the table you created
$con = mysql_connect($hostname,$username, $password) 
  or die ("<html><script language='JavaScript'>alert('Cannot connect.'),history.go(-1)</script></html>");
mysql_select_db($dbname);

if($_SESSION["sUser"] == null || $_SESSION["sUser"] == '')
{
header('Location:' . 'myWebsiteLogin.php');
exit();
}

//Addresses idemptpotency
if($_SESSION["fromMainPage"] == "False")
{
 header('Location:' . 'myWebsiteLogin.php');
 exit(); 
}
else
{
 $_SESSION["fromMainPage"] = "False";
 $_SESSION["fromClassPage"] = "True";
}


//set up menu layout and style
styles();
menu();


//inserts values into db
if($radio == 'Insert') { // if $result is empty there is no output and no message
  
  $query = "INSERT INTO $dbname.$usertable (`id`, `name`, `email`) VALUES (NULL, '$name', '$email')";
  $result2 = mysql_query($query);
}
elseif($radio == 'Delete')
{
//deletes a specific id from the db
  $query = "DELETE FROM $dbname.$usertable WHERE id = '$id'";
  $result2 = mysql_query($query);
}
elseif($radio == 'Update')
{
//Update a specific id from the db
  $query = "UPDATE $dbname.$usertable SET name = '$name',  email = '$email' WHERE id ='$id'";
  $result =  mysql_query($query);
}

if($radio == 'View')
{
//allows you to view a specific id from the db
//$query = "SELECT * FROM $usertable WHERE id = '$id'";
//$result = mysql_query($query);

$usertable = "class";
$query = "SELECT * FROM $usertable WHERE name_id = '$id'";
$result = mysql_query($query);

}
else
{
//displays all values from db
$query = "SELECT * FROM $usertable";
$result = mysql_query($query);
}

//displays table on form
if($result) { // if $result is empty there is no output and no message

if($usertable == "class")
{
  echo "<table border='1' style='width:auto'><tr><td>ID</td><td>Class</td><td>Name ID</td></tr>";
}
elseif($usertable == "table01")
{
  echo "<table border='1' style='width:auto'><tr><td>ID</td><td>Name</td><td>Email</td></tr>";  
}

  while($row = mysql_fetch_array($result)){
    $val0 = $row[0];
    $val1 = $row[1];
    $val2 = $row[2];
    echo "<tr><td> " .$val0. "</td><td> ".$val1."</td><td> ".$val2."</td></tr>"; // generates html code
  }
echo "</table>";
}



//STEP 5: Set up radio buttons
if($usertable == "class")
{
echo '<form action="myWebsiteGradeTable.php" method="post" autocomplete="on">

<input type="radio" name="tableMethod" value="Insert" onClick="RadioInsert()" checked>Insert

<input type="radio" name="tableMethod" value="Delete" onClick="RadioDelete()">Delete

<input type="radio" name="tableMethod" value="Update" onClick="RadioUpdate()">Update

<input type="radio" name="tableMethod" value="View" onClick="RadioView()">View

<!-- Display Fields -->
  <table>
    <tr>
      <td>Table:</td>
      <td><input type="text" name="tableName" size="30" placeholder="Table" value="class" disabled/></td>
    </tr>
    <tr>
        <td>ID: </td> 
		<td><select name="tableId" style="width:60px;">';
 
			//STEP 6: Populate id field with database values	
				$query = "SELECT * FROM $usertable WHERE name_id = '$id'";
                $sql = mysql_query($query);
				while ($row = mysql_fetch_array($sql))
				{
                  echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
				}
echo '</select>';
echo '		</td>
	</tr>
    </tr>
    <tr>
      <td>Class:</td>
      <td><input type="text" name="class" size="30"  placeholder="Class" /></td>
    </tr>
    <tr>
      <td>Name ID:</td>';
echo      "<td><input readonly name='name_id' value='" . $id . "' size='30' placeholder='Name ID'></td>";
echo '   </tr>
    <tr>
      <input type="hidden" name="submitCheck" value="sent"/>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
</form>'; 
}




echo '</div>
      </center>';

//sets all of the styles of the form into a function
function styles()
{
echo '<style>

/*Begin navigation styling */
#nav {
      width: 100%;
      float: left;
      margin: 0 0 0em 0;
      padding: 0;
      list-style: none;
      background-color: #f2f2f2;
      border-bottom: 1px solid #ccc;
      border-top: 1px solid #ccc; }
   #nav li {
      float: left; }
   #nav li a {
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-weight: bold;
      color: #069;
      border-right: 1px solid #ccc; }
   #nav li a:hover {
      color: #c00;
      background-color:#000000;}
/*      background-color: #fff; } */
   /* End navigation bar styling. */

   #wrap {
      width: 750px;
      margin: 0 auto;
      background-color:#C0C0C0; }

   #banner {
      width: 750px;
      margin: 0 auto;
      background-color: #f2f2f2;
      text-align: "left"; }

</style>';

echo '<script language="JavaScript">



function RadioInsert()
{
 document.all.class.style.visibility = "visible";
 document.all.name_id.style.visibility = "visible";
 document.all.tableId.style.visibility = "hidden";
}

function RadioDelete()
{
 document.all.class.style.visibility = "hidden";
 document.all.name_id.style.visibility = "hidden";
 document.all.tableId.style.visibility = "visible";
}

function RadioUpdate()
{
 document.all.class.style.visibility = "visible";
 document.all.name_id.style.visibility = "visible";
 document.all.tableId.style.visibility = "visible";
}

function RadioView()
{
 document.all.class.style.visibility = "hidden";
 document.all.name_id.style.visibility = "hidden";
 document.all.tableId.style.visibility = "visible";
}
</script>';


}
//sets up the body of the form into a function
function menu()
{
echo '<body style="background-color: #555" onload="RadioInsert()">
<center>

<div id="wrap">
<!-- Create menu strip at the top of page -->
  <h1 style="color: #069"> Table Manipulation </h1>
  <ul id="nav">

    <li><a href="myWebsiteLogin.php"> Login </a></li>
    <li><a href="myWebsite.php"> Table Manipulation </a></li>
    <li style="float: right;  border-left: 1px solid #ccc;"><a> ' . $_SESSION["sUser"] . ' is currently logged in </a></li>
  </ul>
  <br>';
}
?>


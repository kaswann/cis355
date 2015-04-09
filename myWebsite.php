<?php
session_set_cookie_params("session.cookie_domain", "csis.svsu.edu/");
session_start();

if($_POST["username"] <> '')
{
$_SESSION["sUser"] = $_POST["username"];
}
$_SESSION["fromMainPage"] = "True";


//if($_SESSION["loggedIn"] != 'True')
//{
//header('Location:' . 'myWebsiteLogin.php');
//}

if($_SESSION["sUser"] == null || $_SESSION["sUser"] == '')
{
header('Location:' . 'myWebsiteLogin.php');
}

//STEP 1: Connect to database
$hostname="localhost"; //always will be used for host
$username="CIS355kaswann"; //Your username for MySQL
$password="impossible"; //your password for My SQL
$dbname="CIS355kaswann"; //Your username for my SQL
$usertable="table01"; //NAme of the table you created
$con = mysql_connect($hostname,$username, $password)
  or die ("<html><script language='JavaScript'>alert('Cannot connect.'),history.go(-1)</script></html>");
mysql_select_db($dbname);


//STEP 2: Create styles and functions
echo '<html>
<head>
<title>My Webpage Data Entry Form</title>
<style>

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

</style>

<script language="JavaScript">



function RadioInsert()
{
 document.all.name.style.visibility = "visible";
 document.all.email.style.visibility = "visible";
 document.all.tableId.style.visibility = "hidden";
}

function RadioDelete()
{
 document.all.name.style.visibility = "hidden";
 document.all.email.style.visibility = "hidden";
 document.all.tableId.style.visibility = "visible";
}

function RadioUpdate()
{
 document.all.name.style.visibility = "visible";
 document.all.email.style.visibility = "visible";
 document.all.tableId.style.visibility = "visible";
}

function RadioView()
{
 document.all.name.style.visibility = "hidden";
 document.all.email.style.visibility = "hidden";
 document.all.tableId.style.visibility = "visible";
}
</script>
</head>';

//STEP 3: Display page header details
echo '
<body style="background-color: #555" onload="RadioInsert()">
<center>

<div id="wrap">
<!-- Create menu strip at the top of page -->
  <h1 style="color: #069"> Table Manipulation </h1>
  <ul id="nav">

    <li><a href="myWebsiteLogin.php"> Login </a></li>
    <li><a href="myWebsite.php"> Table Manipulation </a></li>
    <li style="float: right;  border-left: 1px solid #ccc;"><a> ' . $_SESSION["sUser"] . ' is currently logged in </a></li>
  </ul>
  <br>

 <form action="myWebsiteTables.php" method="post" autocomplete="on">

<div id="banner">
<!-- Select table method -->';

//STEP 4 Display table 
$query = "SELECT * FROM $usertable";
$result = mysql_query($query);

if($result) { // if $result is empty there is no output and no message
  echo "<table border='1' style='width:auto'><tr><td>ID</td><td>Name</td><td>Email</td></tr>";
  while($row = mysql_fetch_array($result)){
    $val0 = $row[0];
    $val1 = $row[1];
    $val2 = $row[2];
    echo "<tr><td> " .$val0. "</td><td> ".$val1."</td><td> ".$val2."</td></tr>"; // generates html code
  }
echo "</table>";
}

//STEP 5: Set up radio buttons
echo '<input type="radio" name="tableMethod" value="Insert" onClick="RadioInsert()" checked>Insert

<input type="radio" name="tableMethod" value="Delete" onClick="RadioDelete()">Delete

<input type="radio" name="tableMethod" value="Update" onClick="RadioUpdate()">Update

<input type="radio" name="tableMethod" value="View" onClick="RadioView()">View

<!-- Display Fields -->
  <table>
    <tr>
      <td>Table:</td>
      <td><input type="text" name="tableName" size="30" placeholder="Table" value="table01" disabled/></td>
    </tr>
    <tr>
        <td>ID: </td> 
		<td><select name="tableId" style="width:60px;">';
 
			//STEP 6: Populate id field with database values	
				$query = "SELECT * FROM $usertable";
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
      <td>Name:</td>
      <td><input type="text" name="name" size="30"  placeholder="Name" /></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" name="email" size="30" placeholder="Email"/></td>
    </tr>
    <tr>
      <input type="hidden" name="submitCheck" value="sent"/>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</div> 
</div>
</center>
</body>
</html>';
?>


<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find Earthquake by State PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
  
$input = $_POST['input'];



$input = mysqli_real_escape_string($conn, $input);
// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
$query = "SELECT eventID, originTime, longitude, latitude, depth, magnitude FROM earthquake WHERE state_ID LIKE  ";
$query = $query."'".$input."' ORDER BY originTime LIMIT 500;";

?>

<p>
The query:
<p>
<?php
print $query;
?>


<p> <a href="./">Back</a> to the previous page. 



<hr>
<p>
Result of query:
<p>


<style>
table, th, td {
  border: 1px solid black;
  border-spacing: 0px;
  padding: 5px;
}
</style>


<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));
$link = "https://earthquake.usgs.gov/earthquakes/eventpage/";
$neq = 0;
print "<table>";
print "<th>eventID</th> <th>originTime (UTC)</th> <th>Longitude</th> <th>Latitude</th> <th>Depth(km)</th> <th>Magnitude</th>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    $link2 = $link . $row[eventID] . "/executive";
    $neq = $neq + 1;
    print "<tr>"; 
    print "<td> <a href='$link2'>$row[eventID]</a></td>";
    print "<td>$row[originTime]</td>";
    print "<td>$row[longitude]</td>"; 
    print "<td>$row[latitude]</td>"; 
    print "<td>$row[depth]</td>"; 
    print "<td>$row[magnitude]</td>"; 
    print "</tr>\n";
  }
print "</table>";

mysqli_free_result($result);

mysqli_close($conn);

print "<p> Total of $neq lines";

?>

<p>
<hr>

<p>
<a href="findEQbyState.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find Earthquake by filters PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
// get parameters from POST
$min_mag = $_POST['min_mag'];
$max_mag = $_POST['max_mag'];
$min_lon = $_POST['min_lon'];
$max_lon = $_POST['max_lon'];
$min_lat = $_POST['min_lat'];
$max_lat = $_POST['max_lat'];
$min_t = $_POST['min_t'];
$max_t = $_POST['max_t'];
$stype = $_POST['stype'];

$min_mag = mysqli_real_escape_string($conn, $min_mag);
$max_mag = mysqli_real_escape_string($conn, $max_mag);
$min_lon = mysqli_real_escape_string($conn, $min_lon);
$max_lon = mysqli_real_escape_string($conn, $max_lon);
$min_lat = mysqli_real_escape_string($conn, $min_lat);
$max_lat = mysqli_real_escape_string($conn, $max_lat);
$min_t = mysqli_real_escape_string($conn, $min_t);
$max_t = mysqli_real_escape_string($conn, $max_t);
$stype = mysqli_real_escape_string($conn, $stype);
// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
$query = "SELECT eventID, originTime, longitude, latitude, depth, magnitude FROM earthquake WHERE  magnitude>=";
$query = $query . $min_mag .  " AND magnitude<=" . $max_mag ;
$query = $query . " AND longitude>=" . $min_lon . " AND longitude<=" . $max_lon;
$query = $query . " AND latitude>=" . $min_lat . " AND latitude<=" . $max_lat;
$query = $query . " AND originTime>=" . "DATE('".$min_t."')" . " AND originTime<=" . "DATE('".$max_t."')";
if ($stype!='All'){
  $query = $query . " AND stype LIKE '" . $stype . "'";
}
$query = $query . " ORDER BY originTime LIMIT 500;"

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
<a href="findEQbyMultifilt.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

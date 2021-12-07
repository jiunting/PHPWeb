<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find station by network PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
// get parameters from POST
$network_ID = $_POST['ID'];

$network_ID = mysqli_real_escape_string($conn, $network_ID);


// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
$query = "SELECT s.code AS scode, s.longitude AS lon, s.latitude AS lat, s.elevation AS elev, s.startTime AS stime, s.endTime AS etime, n.code AS ncode FROM station s JOIN network n ON s.network_ID=n.ID ";
$query = $query . " WHERE n.ID=" . "'" . $network_ID . "'";
$query = $query . " ORDER BY scode ;";

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
$nsta = 0;
print "<table>";
print "<th>StationCode</th> <th>Longitude</th> <th>Latitude</th> <th>Elevation</th> <th>StartTime</th> <th>EndTime</th> <th>NetworkCode</th>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    $nsta = $nsta + 1;
    print "<tr>"; 
    print "<td>$row[scode]</a></td>";
    print "<td>$row[lon]</td>"; 
    print "<td>$row[lat]</td>"; 
    print "<td>$row[elev]</td>"; 
    print "<td>$row[stime]</td>";
    print "<td>$row[etime]</td>";
    print "<td>$row[ncode]</td>"; 
    print "</tr>\n";
  }
print "</table>";

mysqli_free_result($result);

mysqli_close($conn);

print "<p> Total of $nsta lines";

?>

<p>
<hr>

<p>
<a href="findStabyNet.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

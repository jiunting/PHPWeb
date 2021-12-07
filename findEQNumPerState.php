<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find Earthquake number in each state PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  <hr>
  
<?php
  
$min_t = $_POST['min_t'];
$max_t = $_POST['max_t'];
$min_t = mysqli_real_escape_string($conn, $min_t);
$max_t = mysqli_real_escape_string($conn, $max_t);

// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
$query = "SELECT eventID, originTime, longitude, latitude, depth, magnitude FROM earthquake WHERE state_ID LIKE  ";
$query = $query."'".$input."' ORDER BY originTime LIMIT 500;";

$query = "SELECT IFNULL(a.num,0) AS num, sout.name FROM state sout LEFT JOIN (SELECT COUNT(*) AS num, s.ID FROM earthquake e JOIN state s ON e.state_ID=s.ID WHERE e.originTime>=";
$query = $query . " DATE('".$min_t."')" . " AND originTime<=" . "DATE('".$max_t."')";
$query = $query . " GROUP BY e.state_ID)a USING(ID) ORDER BY a.num DESC";


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
$neq = 0;
print "<table>";
print "<th>Number</th> <th>State</th>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    $neq = $neq + 1;
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[name]</td>"; 
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
<a href="findEQNumPerState.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

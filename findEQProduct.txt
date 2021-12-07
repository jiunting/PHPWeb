<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find Earthquake product PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
// get parameters from POST
$min_mag = $_POST['min_mag'];
$max_mag = $_POST['max_mag'];
$mt_flag = $_POST['mt_flag'];
$ff_flag = $_POST['ff_flag'];


$min_mag = mysqli_real_escape_string($conn, $min_mag);
$max_mag = mysqli_real_escape_string($conn, $max_mag);
$mt_flag = mysqli_real_escape_string($conn, $mt_flag);
$ff_flag = mysqli_real_escape_string($conn, $ff_flag);


// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
$query = "SELECT eventID, originTime, focalMechanism, finiteFault  FROM earthquake e JOIN product p ON e.eventID=p.earthquake_eventID";
$query = $query . " WHERE magnitude>=" . $min_mag;
$query = $query . " AND magnitude<=" . $max_mag;
if ($mt_flag=='mt_on'){
  $query = $query . " AND focalMechanism IS NOT NULL ";
//}else{
//  $query = $query . " AND focalMechanism IS NULL ";
}
if ($ff_flag=='ff_on'){
  $query = $query . " AND finitefault IS NOT NULL ";
//}else{
//  $query = $query . " AND finitefault IS NULL ";
}
$query = $query . " ORDER BY originTime ;";

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
$link = "https://earthquake.usgs.gov/earthquakes/eventpage/";
print "<table>";
// print "<th>eventID</th> <th>originTime</th> <th>focalMechanism</th> <th>finiteFault</th> ";
print "<th>eventID</th> <th>originTime</th> ";
if ($mt_flag=='mt_on'){
  print "<th>focalMechanism</th>";
}
if ($ff_flag=='ff_on'){
  print "<th>finiteFault</th>";
}
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    $nsta = $nsta + 1;
    $link2 = $link . $row[eventID] . "/executive";
    print "<tr>"; 
    print "<td> <a href='$link2'>$row[eventID]</a></td>";
    print "<td>$row[originTime]</td>"; 
    if ($mt_flag=='mt_on'){
      print "<td>$row[focalMechanism]</td>"; 
    }
    if ($ff_flag=='ff_on'){
      print "<td><a href='$row[finiteFault]'><img src='$row[finiteFault]' width='30%'></a></td>";
      //print "<td>$row[finiteFault]</td>";
    } 
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
<a href="findEQProduct.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find CustManu PHP-MySQL Program</title>
</head>
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
  
// $state = $_POST['state'];
$manu = $_POST['manu'];

// $state = mysqli_real_escape_string($conn, $state);
$manu = mysqli_real_escape_string($conn, $manu);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

// $query = "SELECT DISTINCT firstName, lastName, city FROM customer WHERE state = ";
// $query = $query."'".$state."' ORDER BY 2;";
//$query = $query."'".$state."' ORDER BY 2;";
$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
$query = $query."'".$manu."' ;";

?>

<p>
The query:
<p>
<?php
print $query;
?>

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

// print "<pre>";
print "<table>";
print "<th>fullName</th> <th>description</th> <th>manu_name</th>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    // print "\n";
    // print "$row[fullName]\t $row[description]\t $row[manu_name]";
    // print "$row[firstName]  $row[lastName] $row[city]";
    print "<tr>"; 
    print "<td>$row[fullName]</td>";
    print "<td>$row[description]</td>";
    print "<td>$row[manu_name]</td>"; 
    print "</tr>\n";
  }
// print "</pre>";
print "</table>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
<a href="findCustManu.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

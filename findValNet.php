<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>


<html>

<head>
       <title>Find the most valuable network PHP-MySQL Program</title>
</head>
  <body bgcolor="white"; onload="sortTable()">
  
  <hr>
  
<?php
  
// $min_t = $_POST['min_t'];
// $max_t = $_POST['max_t'];
// $min_t = mysqli_real_escape_string($conn, $min_t);
// $max_t = mysqli_real_escape_string($conn, $max_t);

// this is a small attempt to avoid SQL injection
// better to use prepared statements
#$query = "SELECT CONCAT(c.fname,' ',c.lname) AS fullName, c.customer_num, s.description, m.manu_name FROM customer c JOIN orders o USING(customer_num) JOIN items i USING(order_num) JOIN stock s USING(stock_num,manu_code) JOIN manufact m USING(manu_code) WHERE m.manu_name LIKE  ";
#$query = $query."'".$manu."' ;";
// List all earthquakes based on the state ID (e.g. CA,OR,NY etc)
// $query = "SELECT eventID, originTime, longitude, latitude, depth, magnitude FROM earthquake WHERE state_ID LIKE  ";
// $query = $query."'".$input."' ORDER BY originTime LIMIT 500;";
// $query = "SELECT IFNULL(a.num,0) AS num, sout.name FROM state sout LEFT JOIN (SELECT COUNT(*) AS num, s.ID FROM earthquake e JOIN state s ON e.state_ID=s.ID WHERE e.originTime>=";
// $query = $query . " DATE('".$min_t."')" . " AND originTime<=" . "DATE('".$max_t."')";
// $query = $query . " GROUP BY e.state_ID)a USING(ID) ORDER BY a.num DESC";
$query1 = "SELECT COUNT(*) AS num, a.code, a.description FROM (SELECT DISTINCT eventID, n.ID , n.code, n.description FROM earthquake_has_station es JOIN earthquake e USING(eventID) JOIN station s USING(stationID) JOIN network n ON n.ID=s.network_ID WHERE n.ID>=0 AND n.ID<200 ) a  GROUP BY a.ID";
$query2 = "SELECT COUNT(*) AS num, a.code, a.description FROM (SELECT DISTINCT eventID, n.ID , n.code, n.description FROM earthquake_has_station es JOIN earthquake e USING(eventID) JOIN station s USING(stationID) JOIN network n ON n.ID=s.network_ID WHERE n.ID>=200 AND n.ID<250 ) a  GROUP BY a.ID";
$query3 = "SELECT COUNT(*) AS num, a.code, a.description FROM (SELECT DISTINCT eventID, n.ID , n.code, n.description FROM earthquake_has_station es JOIN earthquake e USING(eventID) JOIN station s USING(stationID) JOIN network n ON n.ID=s.network_ID WHERE n.ID>=250 AND n.ID<300 ) a  GROUP BY a.ID";
$query4 = "SELECT COUNT(*) AS num, a.code, a.description FROM (SELECT DISTINCT eventID, n.ID , n.code, n.description FROM earthquake_has_station es JOIN earthquake e USING(eventID) JOIN station s USING(stationID) JOIN network n ON n.ID=s.network_ID WHERE n.ID>=300 AND n.ID<400 ) a  GROUP BY a.ID";
$query5 = "SELECT COUNT(*) AS num, a.code, a.description FROM (SELECT DISTINCT eventID, n.ID , n.code, n.description FROM earthquake_has_station es JOIN earthquake e USING(eventID) JOIN station s USING(stationID) JOIN network n ON n.ID=s.network_ID WHERE n.ID>=400 ) a GROUP BY a.ID";


?>

<p>
The query are splitted into 5 subqueries, below is one of them:
<p>
<?php
print $query1;
?>


<p> <a href="./">Back</a> to the previous page. 



<hr>
<p>
Result of query:
<p>
Querying from 8 million rows may take a few minutes, please wait.....


<style>
table, th, td {
  border: 1px solid black;
  border-spacing: 0px;
  padding: 5px;
}
</style>



<?php
$result1 = mysqli_query($conn, $query1)
or die(mysqli_error($conn));
$result2 = mysqli_query($conn, $query2)
or die(mysqli_error($conn));
$result3 = mysqli_query($conn, $query3)
or die(mysqli_error($conn));
$result4 = mysqli_query($conn, $query4)
or die(mysqli_error($conn));
$result5 = mysqli_query($conn, $query5)
or die(mysqli_error($conn));
print "<table id='myTable'>";
print "<th>Number</th> <th>Network</th> <th>Description</th>";
while($row = mysqli_fetch_array($result1, MYSQLI_BOTH))
  {
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[code]</td>"; 
    print "<td>$row[description]</td>"; 
    print "</tr>\n";
  }
while($row = mysqli_fetch_array($result2, MYSQLI_BOTH))
  {
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[code]</td>"; 
    print "<td>$row[description]</td>";
    print "</tr>\n";
  }
while($row = mysqli_fetch_array($result3, MYSQLI_BOTH))
  {
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[code]</td>"; 
    print "<td>$row[description]</td>";
    print "</tr>\n";
  }
while($row = mysqli_fetch_array($result4, MYSQLI_BOTH))
  {
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[code]</td>"; 
    print "<td>$row[description]</td>";
    print "</tr>\n";
  }
while($row = mysqli_fetch_array($result5, MYSQLI_BOTH))
  {
    print "<tr>"; 
    print "<td>$row[num]</td>";
    print "<td>$row[code]</td>"; 
    print "<td>$row[description]</td>";
    print "</tr>\n";
  }

print "</table>";

mysqli_free_result($result1);
mysqli_free_result($result2);
mysqli_free_result($result3);
mysqli_free_result($result4);
mysqli_free_result($result5);
mysqli_close($conn);
?>



<script>
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      // if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
      if ( parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>



<p>
<hr>

<p>
<a href="findValNet.txt" >Contents</a>
of the PHP program that created this page. 	 
 

<p> <a href="./">Back</a> to the query page. 


</body>
</html>
	  

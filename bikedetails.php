<?php
include('dbconnect.php');


$id = $_GET['id'];
echo $id;
// pull info from db based on $id
#$sql = mysql_query('SELECT LocationID from location WHERE Branch_name ="'.$id.'"');
$sql = "SELECT LocationID from location WHERE Branch_name ='".$id."'";
#echo $sql;
$result = $conn->query($sql);

#$location_id = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)) {
	$location_id = $row["LocationID"];
    }
#echo $location_id;

$sql = "SELECT Model, Bike_Type from bike WHERE LocationID ='".$location_id."'";
$result = $conn->query($sql);
echo "<table cellspacing=10>";
while($row = mysqli_fetch_assoc($result)) {
	$model = $row["Model"];
	$bike_type = $row["Bike_Type"];
	#echo "<tr><td>".$model."</td><td>".$bike_type."</td></tr>";
	$sql_temp1 = "SELECT Bike_model from bike_model WHERE Bike_Model_ID ='".$model."'";
	$sql_temp2 = "SELECT Bike_Type,hourly_rate from bike_type WHERE Bike_Type_ID ='".$bike_type."'";
	$result_temp1 = $conn->query($sql_temp1);
	$result_temp2 = $conn->query($sql_temp2);
	while($row_temp1 = mysqli_fetch_assoc($result_temp1))
	{
		echo "<tr><td>Bike model :".$row_temp1["Bike_model"]."</td></tr><tr></tr>";
	}
	while($row_temp2 = mysqli_fetch_assoc($result_temp2))
	{
		echo "<tr><td> Bike Type :".$row_temp2["Bike_Type"]."</td><td> price:".$row_temp2["hourly_rate"]."</td></tr>";
	}		 
	echo "<tr><td></td></tr>";
	
	
    }
echo "</table>";
#echo $sql;





?>

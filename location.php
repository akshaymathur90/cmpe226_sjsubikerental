<?php
include('dbconnect1.php');

session_start();
$sql = "SELECT * FROM location";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    echo "Location List<br><br>";
    print "<p> hello " . $_SESSION["userid"] ."</p>\n";
    echo "<table>";
    while($row = mysqli_fetch_assoc($result)) {
	echo '<tr><a href="bikedetails.php?id='.$row["Branch_name"].'">'.$row["Branch_name"].'</a><br></tr>';
        #echo "<tr>".$row["Branch_name"]. "</tr><br>";
    }
    echo "</table>";
} else {
    echo "0 results";
}



?>

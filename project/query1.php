<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Simple Query #1</title>
</head>

<body>
    <?php
    include_once(__DIR__ . "/dbconnect.php");

  try {
            // Connect to the database.
            $con = connectDB();
            $bikeTypes = $_POST['bikeType'];
            $years = $_POST['year'];
            $quarters = $_POST['quarter'];
            $query = "SELECT Bike_Dimension.BikeType,Calendar_Dimension.Year,Calendar_Dimension.Quarter,COUNT(BookingID) as numberOfBikes 
                      from 
                      Booking_Fact,Bike_Dimension,Calendar_Dimension 
                      where 
                      Booking_Fact.BikeKey=Bike_Dimension.BikeKey and Booking_Fact.CalendarKey=Calendar_Dimension.CalendarKey AND 
                      Bike_Dimension.BikeType in (' ".implode("','",$bikeTypes)."') AND
                      Calendar_Dimension.Year in (". implode(",",$years).") AND
                      Calendar_Dimension.Quarter in (". implode(",",$quarters).")
                      GROUP BY Bike_Dimension.BikeType,Calendar_Dimension.Year,Calendar_Dimension.Quarter ";
            echo $query;          
            $ps = $con->prepare($query);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
            // Fetch the matching row.
            $ps->execute();
            $data = $ps->fetchAll();
            if (count($data) ==0) {
            print "<h3>No match for this query.</h3>\n";
            }
            else {
            $isheader = true;
                print "<table border='2'>\n";
                foreach ($data as $row) {
                	print "            <tr>\n";
                	if ($isheader) {
				        print "        <tr>\n";
				        foreach ($row as $name => $value) {
				            print "            <th>$name</th>\n";
				        }
				        print "        </tr>\n";
				        
				        $doHeader = false;
				    }
				    $isheader = false;
				    print "            <tr>\n";
	                foreach ($row as $field => $value) {
	                    print "               <td>$value</td>\n";
	                }
	                
	                print "            </tr>\n";
                }
                
                print"</table>";
                
            }
          
        }
        catch(PDOException $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }    
        catch(Exception $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }
    ?>
</body>
</html>
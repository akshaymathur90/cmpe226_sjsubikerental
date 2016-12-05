<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Bookings across Bike Types</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body class="container">
    <?php
    include_once(__DIR__ . "/dbconnect_olap.php");

  try {
             
            // Connect to the database.
            $con = connectDB();
            $query = "SELECT Calendar_Dimension.Quarter,COUNT(Distinct(Customer_dimension.customerID)) as numberOfCustomers
                     from Booking_Fact,Calendar_Dimension, Customer_dimension 
                     where Calendar_Dimension.Year=2016 
                     and Booking_Fact.CalendarKey=Calendar_Dimension.CalendarKey
                     and Booking_Fact.Customerkey = Customer_dimension.CustomerKey
                     GROUP BY Calendar_Dimension.Quarter";
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
                
                print "<div class=\"row\"><div class=\"col-md-4\">";
                print "<table class=\"table\">\n";
                foreach ($data as $row) {
                	print "<tr  class='success'>\n";
                	if ($isheader) {
				        print "<tr>\n";
				        foreach ($row as $name => $value) {
				            print "<th>$name</th>\n";
				        }
				        print "</tr>\n";
				        
				        $doHeader = false;
				    }
				    $isheader = false;
				    print " <tr  class='success'>\n";
	                foreach ($row as $field => $value) {
	                    print "<td>$value</td>\n";
	                }
	                print "</tr>\n";
                }
                
                print"</table></div>";
                print "<div class=\"col-md-8\"> ";
                print "<script type='text/javascript' src='https://10az.online.tableau.com/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1284px; height: 557px;'><object class='tableauViz' width='1284' height='557' style='display:none;'><param name='host_url' value='https%3A%2F%2F10az.online.tableau.com%2F' /> <param name='site_root' value='&#47;t&#47;sjsubikerental' /><param name='name' value='CustomerQuarter&#47;Sheet2' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='showShareOptions' value='true' /></object></div>";
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
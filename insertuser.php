<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Insert New User</title>
</head>

<body>
    <?php
    // make database connection
    include_once(__DIR__ . "/dbconnect.php");
    $con = connectDB();
    try{


    	
        print "<h1>I am here</h1>\n";

    	
    		$userEmail = filter_input(INPUT_GET,"userEmail");
    		$userPassword = filter_input(INPUT_GET,"userpassword");
    		$userPhoneNumber = filter_input(INPUT_GET,"userPhoneNumber");
    		$streetAddress = filter_input(INPUT_GET,"streetAddress");
    		$aptNumber = filter_input(INPUT_GET,"apt_number");
    		$cityName = filter_input(INPUT_GET,"city_name");
    		$stateName = filter_input(INPUT_GET,"state_name");
    		$zipCode = filter_input(INPUT_GET,"zipcode");

    		print "<p> hello " . $userEmail ."</p>\n";

            



    	
            //insert into address table
            //read max address id
            $con->beginTransaction();
            $maxAddressIDQuery = "SELECT max(addressid) from address";
            $ps = $con->prepare($maxAddressIDQuery);
            $ps->execute();
            $row = $ps->fetch();

            print "<p> max address id " . $row ['max(addressid)'] ."</p>\n";

            // add 1 to the max id
            $newAddressID = $row ['max(addressid)'] + 1;
            print "<p> new address id " . $newAddressID ."</p>\n";

            $zipCodeQuery = "SELECT zipcode from zipcodes where zipcode=:zipcode";
            $zipPS = $con->prepare($zipCodeQuery);
            $zipPS->bindParam(':zipcode', $zipCode);
            $zipPS->execute();
            $rows = $zipPS->fetchAll(PDO::FETCH_ASSOC);
            
            //$row = $ps->fetch();

            if(count($rows) > 0){
                print "<p>Zipcode exits</p>\n";
            }
            else{
                
                print "<p>Zipcode does not exits ". $zipCode ."</p>\n";
                $country ="United States";
                $insertNewZipCodeQuery = "INSERT INTO `zipcodes`(`Zipcode`, `City`, `State`, `Country`) VALUES (:zipcode,:city,:state,:country)";
                $insertNewZipCode = $con->prepare($insertNewZipCodeQuery);
                $insertNewZipCode->bindParam(':zipcode', $zipCode);
                $insertNewZipCode->bindParam(':city', $cityName);
                $insertNewZipCode->bindParam(':state', $stateName);
                $insertNewZipCode->bindParam(':country', $country);
                $insertNewZipCode->execute();


            }

            
            
            
            //write insert query
            $insertNewUserAddressQuery = "INSERT INTO `address`(`AddressID`, `Street`, `AptNo`, `Zipcode`) VALUES (:addressid,:street,:aptno,:zipcode)";
            $insertUserAddressStmt = $con->prepare($insertNewUserAddressQuery);
            $insertUserAddressStmt->bindParam(':addressid', $insertNewUserQuery);
            $insertUserAddressStmt->bindParam(':street', $streetAddress);
            $insertUserAddressStmt->bindParam(':aptno', $aptNumber);
            $insertUserAddressStmt->bindParam(':zipcode', $zipCode);
            $insertUserAddressStmt->execute();



            //insert into person table
            $insertPersonQuery = "INSERT INTO `person`(`PersonID`, `Name`, `AddressID`,`password`) VALUES (:personID,:name,:addressID,:password)";
            $maxPersonIDQuery = "SELECT max(personid) from person";
            $psPersonID = $con->prepare($maxPersonIDQuery);
            $psPersonID->execute();
            $row = $psPersonID->fetch();

            print "<p> max person id " . $row ['max(personid)'] ."</p>\n";

            // add 1 to the max id
            $newPersonID = $row ['max(personid)'] + 1;
            print "<p> new person id " . $newPersonID ."</p>\n";

            $insertPersonStmt = $con->prepare($insertPersonQuery);
            $insertPersonStmt->bindParam(':personID', $newPersonID);
            $insertPersonStmt->bindParam(':name', $userEmail);
            $insertPersonStmt->bindParam(':addressID', $newAddressID);
            $insertPersonStmt->bindParam(':password', $userPassword);
            $insertPersonStmt->execute();


            //insert into customer table
            $insertCustomerQuery = "INSERT INTO `customer`(`PersonID`) VALUES (:personID)";
            $insertCustomerStmt = $con->prepare($insertCustomerQuery);
            $insertCustomerStmt->bindParam(':personID', $newPersonID);
            $insertCustomerStmt->execute();

            //insert phone number
            $insertPhoneNumberQuery = "INSERT INTO `person_phone_number`(`phone_number`, `PersonID`) VALUES (:phonenumber,:personID)";
            $insertPhoneNumberStmt = $con->prepare($insertPhoneNumberQuery);
            $insertPhoneNumberStmt->bindParam(':phonenumber', $userPhoneNumber);
            $insertPhoneNumberStmt->bindParam(':personID', $newPersonID);
            $insertPhoneNumberStmt->execute();

            $con->commit();
        }
        catch(PDOException $ex) {
            echo 'ERROR: '.$ex->getMessage();
            $con->rollBack();

        }    
        catch(Exception $ex) {
            echo 'ERROR: '.$ex->getMessage();
            $con->rollBack();
        }


        

     ?>
</body>
</html>
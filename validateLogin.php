<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Validate Login</title>
</head>

<body>
    <?php
        include_once(__DIR__ . "/dbconnect.php");
    	$userEmail = $_POST['userEmailAddress'];
    	$userPassword = $_POST['userPassword'];

     //    print "world";
    	// print "<p> hello " . $userEmail ."</p>\n";
    	// print "<p> hello " . $userPassword ."</p>\n";

    	// $con = connectDB();

        $sql = "SELECT personid from person where name=\"".$userEmail."\" and password=\"".$userPassword."\";";
    	#$loginCredentialQuery = "SELECT personid from person where name=:username and password=:password";
        //echo $sql;
        $result = $conn->query($sql);
        #var_dump($result);
       
        if (mysqli_num_rows($result) > 0){
                print "<p>Valid User credentials</p>\n";
                session_start();
                while($row = mysqli_fetch_assoc($result)) {
                    $_SESSION["userid"] = $row["personid"];
                    print "<p> hello " . $_SESSION["userid"] ."</p>\n";

                }
               echo '<script type="text/javascript"> window.location = "./location.php" </script>';
            }
            else{
            	print "<p>Invalid User credentials</p>\n";
            }
            
     ?>
</body>
</html>
